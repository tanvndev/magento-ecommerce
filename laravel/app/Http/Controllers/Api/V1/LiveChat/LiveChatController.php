<?php

namespace App\Http\Controllers\Api\V1\LiveChat;

use App\Models\Chat;
use App\Models\User;
use App\Enums\ResponseEnum;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveChatController extends Controller
{

    public function getChatList()
    {
        try {
            $users = User::where('user_catalogue_id', ResponseEnum::TYPE_USER)
                ->with(['chat' => function ($query) {
                    $query->orderBy('created_at', 'desc')->first();
                }])
                ->get();

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
            'message' => 'required|string|max:1000', // Giới hạn độ dài tin nhắn
        ]);

        $message = Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
            'is_read' => false,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return successResponse(__('messages.create.success'), $message, true);
    }


    public function getMessage($userId)
    {
        try {
            // Lấy tất cả tin nhắn giữa người dùng và admin
            $messages = Chat::where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', auth()->id()); // auth()->id() là ID của admin
            })->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $userId);
            })
                ->orderBy('created_at', 'asc') // Sắp xếp theo thời gian tạo
                ->get();

            Chat::where([
                'sender_id' => $userId,
                'is_read' => false,
            ])->update(['is_read' => true]);


            return successResponse(__('messages.retrieve.success'), $messages, true);
        } catch (\Illuminate\Database\QueryException $e) {
            return errorResponse(__('messages.database_error'), true);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage(), true);
        }
    }
}
