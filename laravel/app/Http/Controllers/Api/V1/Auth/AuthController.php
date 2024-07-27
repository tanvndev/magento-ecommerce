<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{
    ForgotRequest,
    LoginRequest,
    RegisterRequest
};
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\Interfaces\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
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
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Kiểm tra xác thực email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'status' => ResponseEnum::UNAUTHORIZED,
                'messages' => ['Email hoặc mật khẩu không chính xác.'],
                'data' => []
            ], ResponseEnum::UNAUTHORIZED);
        }

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'status' => ResponseEnum::UNAUTHORIZED,
                'messages' => ['Vui lòng xác nhận email của bạn trước khi đăng nhập.'],
                'data' => []
            ], ResponseEnum::UNAUTHORIZED);
        }

        // Đăng nhập bằng JWTAuth
        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token, 'Đăng nhập thành công.');
        }

        return response()->json([
            'status' => ResponseEnum::UNAUTHORIZED,
            'messages' => ['Email hoặc mật khẩu không chính xác.'],
            'data' => []
        ], ResponseEnum::UNAUTHORIZED);
    }

    public function forgotPassword(ForgotRequest $request)
    {
        $response = $this->authService->resetPassword();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    public function me()
    {
        $user = new UserResource(auth()->user());
        return response()->json($user);
    }
    protected function respondWithToken($token, $message)
    {
        return response()->json([
            'status' => ResponseEnum::OK,
            'messages' => [$message],
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]
        ], ResponseEnum::OK)->cookie(
            'access_token',
            $token,
            config('jwt.ttl'),
            '/',
            'localhost',
            false,
            true
        );
    }

    public function refreshToken()
    {
        return $this->respondWithToken(auth()->refresh(), 'Token đã được thay đổi');
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => ResponseEnum::OK,
            'messages' => 'Đăng xuất thành công.',
            'data' => []
        ], ResponseEnum::OK);
    }
}
