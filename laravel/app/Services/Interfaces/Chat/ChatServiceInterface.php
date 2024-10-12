<?php

namespace App\Services\Interfaces\Chat;

interface ChatServiceInterface
{
    public function getChatList();

    public function getChatListUser();

    public function sendMessage(string $receiverId);

    public function getMessage(string $senderId);
}
