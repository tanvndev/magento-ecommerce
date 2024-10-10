<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotificationByUser(): JsonResponse
    {
        $user = auth()->user();
        return successResponse('Successfully retrieved notifications', $user->notifications->take(5), true);
    }

    public function readNotification(Request $request, string $id): JsonResponse
    {
        $user = auth()->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        return successResponse('Successfully read notifications', null, true);
    }
}
