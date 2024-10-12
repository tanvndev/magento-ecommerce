<?php

namespace App\Http\Controllers\Api\V1\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SendMessegeRequest;
use App\Services\Interfaces\Chat\ChatServiceInterface;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{

    public function __construct(
        protected ChatServiceInterface $chatService
    ) {}

    public function getChatList(): JsonResponse
    {
        $response = $this->chatService->getChatList();

        return handleResponse($response);
    }


    public function sendMessage(SendMessegeRequest $request, string $receiverId): JsonResponse
    {
        $response = $this->chatService->sendMessage($receiverId);

        return handleResponse($response);
    }


    public function getMessage(string $senderId): JsonResponse
    {
        $response = $this->chatService->getMessage($senderId);

        return handleResponse($response);
    }
}
