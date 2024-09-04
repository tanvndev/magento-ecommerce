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
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(
        AuthServiceInterface $authService
    ) {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->authService->register();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        // Kiểm tra xác thực email
        $user = User::where('email', $credentials['email'])->first();

        if (! $user) {
            return errorResponse('Email hoặc mật khẩu không chính xác.');
        }

        if (! $user->hasVerifiedEmail()) {
            return errorResponse('Vui lòng xác nhận email của bạn trước khi đăng nhập.');
        }

        // Đăng nhập bằng JWTAuth
        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token, 'Đăng nhập thành công.');
        }

        return errorResponse('Email hoặc mật khẩu không chính xác.');
    }

    public function forgotPassword(ForgotRequest $request)
    {
        $response = $this->authService->resetPassword();

        return handleResponse($response);
    }

    public function me()
    {
        $user = new UserResource(auth()->user());

        return response()->json($user);
    }

    public function refreshToken()
    {
        return $this->respondWithToken(auth()->refresh(), 'Token đã được thay đổi');
    }

    private function respondWithToken($token, $message)
    {
        return response()->json([
            'status' => ResponseEnum::OK,
            'messages' => [$message],
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
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

    public function logout()
    {
        return successResponse('Đăng xuất thành công.');
    }
}
