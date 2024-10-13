<?php

namespace App\Events\Chat;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        Log::info('Broadcasting message', [
            'sender'   => $this->message->sender_id,
            'receiver' => $this->message->receiver_id,
        ]);

        return [
            new PrivateChannel('chat-channel.' . $this->message->sender_id),
            new PrivateChannel('chat-channel.' . $this->message->receiver_id),
        ];
    }

    public function broadcastAs()
    {
        return 'message-sent-event';
    }
}
