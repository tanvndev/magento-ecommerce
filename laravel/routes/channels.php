<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('chat-channel.{userId}', function ($user, $userId) {
//     Log::info('Channel auth attempt', ['user' => $user->id, 'channel' => $userId]);
//     return (int) $user->id === (int) $userId;
// });

Broadcast::channel('chat-channel.{userId}', function ($user, $userId) {
    try {
        $tokenUser = JWTAuth::parseToken()->authenticate();

        return $tokenUser->id == $userId;
    } catch (\Exception $e) {
        return false;
    }
});
