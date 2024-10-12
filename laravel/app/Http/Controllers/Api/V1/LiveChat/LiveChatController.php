<?php

namespace App\Http\Controllers\Api\V1\LiveChat;

use App\Models\Chat;
use App\Models\User;
use App\Enums\ResponseEnum;
use App\Events\Chat\MessageSentEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveChatController extends Controller
{

    public function getChatList()
    {
        try {
            // $users = User::where('user_catalogue_id', User::ROLE_CUSTOMER)
            //     ->with(['chat' => function ($query) {
            //         $query->orderBy('created_at', 'desc')->first();
            //     }])
            //     ->get();

            $users = User::all();

            return successResponse('', $users, true);
        } catch (\Illuminate\Database\QueryException $e) {
            return errorResponse(__('messages.database_error'), true);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage(), true);
        }
    }


    public function sendMessage(Request $request, $receiverId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
            'is_read' => false,
        ]);


        event(new MessageSentEvent($message));

        return successResponse(__('messages.create.success'), $message, true);
    }


    public function getMessage(string $senderId)
    {
        try {
            // Lấy tất cả tin nhắn giữa người dùng và admin
            $messages = Chat::where(function ($query) use ($senderId) {
                $query->where('sender_id', $senderId)
                    ->where('receiver_id', auth()->id());
            })
                ->orWhere(function ($query) use ($senderId) {
                    $query->where('sender_id', auth()->id())
                        ->where('receiver_id', $senderId);
                })
                ->with(['sender', 'receiver'])
                ->orderBy('created_at', 'asc') // Sắp xếp theo thời gian tạo
                ->get();

            Chat::where([
                'sender_id' => $senderId,
                'read_at' => false,
            ])->update(['read_at' => true]);


            return successResponse(__('messages.retrieve.success'), $messages, true);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage(), true);
        }
    }
}
