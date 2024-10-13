<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Classes\Stringee;
use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Requests\Auth\LoginOtpRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\Client\ClientUserResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\Interfaces\Auth\AuthServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    protected $currentUser = null;

    public function __construct(
        AuthServiceInterface $authService
    ) {
        $this->middleware('throttle:5,1')->only(['login', 'register', 'sendVerificationCode']);

        $this->currentUser = Auth::user();
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

        $user = User::where('email', $credentials['email'])->first();

        if (! $user) {
            return errorResponse('Email hoặc mật khẩu không chính xác.');
        }

        if (! $user->hasVerifiedEmail()) {
            return errorResponse('Vui lòng xác nhận email của bạn trước khi đăng nhập.');
        }

        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token, 'Đăng nhập thành công.', $user);
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
        $user =
            $this->currentUser->user_catalogue->id == User::ROLE_CUSTOMER
            ?
            new ClientUserResource($this->currentUser)
            :
            new UserResource($this->currentUser);

        return response()->json($user, ResponseEnum::OK);
    }

    public function refreshToken()
    {
        return $this->respondWithToken(auth()->refresh(), 'Token đã được thay đổi');
    }

    private function respondWithToken($token, $message, $user = null)
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

    public function logout()
    {
        auth()->logout();

        return successResponse('Đăng xuất thành công.');
    }

    /**
     * Send a verification code to the user's phone number.
     */
    public function sendVerificationCode(Request $request): JsonResponse
    {
        if (auth()->check()) {
            $response = Stringee::sendVerificationCode($request, $this->currentUser);

            return handleResponse($response);
        }

        $phone = $request->input('phone');
        if (! $phone) {
            return errorResponse('Vui lòng nhập số điện thoại.', true);
        }
        $user = User::where('phone', $phone)->first();
        if (! $user) {
            return errorResponse('Số điện thoại không tồn tại trong hệ thống.', true);
        }

        $response = Stringee::sendVerificationCode($request, $user);

        return handleResponse($response);
    }

    /**
     * Verify the verification code that was sent to the user's phone number.
     */
    public function verifyCode(Request $request): JsonResponse
    {
        $response = Stringee::verifyCode($request, $this->currentUser);

        return handleResponse($response);
    }
}
