<?php

namespace App\Http\Controllers\Api\V1\LiveChat;

use App\Models\Chat;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveChatController extends Controller
{
    public function sendMessage(Request $request)
    {

        // $userId = auth()->id();
        // $msg = $request->message;

        // $message = Chat::create([
        //     'user_id' => $userId,
        //     'message' => $msg
        // ]);

        // broadcast(new MessageSent($userId, $msg))->toOthers();

        return response()->json(['message' => 'success'], 200);
    }
}
