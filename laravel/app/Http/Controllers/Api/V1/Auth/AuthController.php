<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\Interfaces\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(
        AuthServiceInterface $authService
    ) {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     *
     * @param  \App\Http\Requests\Auth\RegisterRequest  $request
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $response = $this->authService->register();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Log in an existing user.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if ( ! $user) {
            return errorResponse('Email hoặc mật khẩu không chính xác.', true);
        }

        if ( ! $user->hasVerifiedEmail()) {
            return errorResponse('Vui lòng xác nhận email của bạn trước khi đăng nhập.', true);
        }

        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token, 'Đăng nhập thành công.', $user);
        }

        return errorResponse('Email hoặc mật khẩu không chính xác.', true);
    }

    /**
     * Handle password reset for a user.
     *
     * @param  \App\Http\Requests\Auth\ForgotRequest  $request
     */
    public function forgotPassword(ForgotRequest $request): JsonResponse
    {
        $response = $this->authService->resetPassword();

        return handleResponse($response);
    }

    /**
     * Get the authenticated user's information.
     */
    public function me(): JsonResponse
    {
        $user = new UserResource(auth()->user());

        return response()->json($user);
    }

    /**
     * Refresh the authentication token.
     */
    public function refreshToken(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh(), 'Token đã được thay đổi');
    }

    private function respondWithToken(string $token, string $message, ?User $user = null): JsonResponse
    {
        return response()->json([
            'status'   => ResponseEnum::OK,
            'messages' => [$message],
            'data'     => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'catalogue'    => $user->user_catalogue->code ?? null,
                'expires_in'   => auth()->factory()->getTTL() * 60,
            ],
        ], ResponseEnum::OK)->cookie(
            'access_token',
            $token,
            config('jwt.ttl'),
            '/',
            '127.0.0.1',
            false,
            true
        );
    }

    /**
     * Logout user (Revoke the token)
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return successResponse('Đăng xuất thành công.', [], true);
    }
}
