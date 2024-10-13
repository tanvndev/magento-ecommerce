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
<<<<<<< HEAD
=======
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
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

<<<<<<< HEAD
        return handleResponse($response, ResponseEnum::CREATED);
=======
            $response = $this->authService->register();

            return handleResponse($response, ResponseEnum::CREATED);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), true);
        }
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if ( ! $user) {
            return errorResponse('Email hoặc mật khẩu không chính xác.');
        }

        if ( ! $user->hasVerifiedEmail()) {
            return errorResponse('Vui lòng xác nhận email của bạn trước khi đăng nhập.');
        }

        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token, 'Đăng nhập thành công.', $user);
        }

        return errorResponse('Email hoặc mật khẩu không chính xác.');
    }

<<<<<<< HEAD
    public function forgotPassword(ForgotRequest $request)
=======
    public function loginOtp(LoginOtpRequest $request): JsonResponse
    {
        $response = $this->verifyRecaptcha($request->input('g-recaptcha-response'));

        if ( ! $response) {
            return errorResponse('Xác minh captcha không thành công', true);
        }

        $credentials = $request->only('phone');

        $user = User::where('phone', $credentials['phone'])->first();

        $response = Stringee::verifyCode($request, $user);

        if ($response['status'] == 'error') {
            return errorResponse($response['messages'], true);
        }

        if ( ! $user->hasVerifiedEmail()) {
            return errorResponse('Vui lòng xác nhận email của bạn trước khi đăng nhập.', true);
        }

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token, 'Đăng nhập thành công.', $user);
    }

    /**
     * Verify the given reCAPTCHA token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function verifyRecaptcha($token)
    {
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        return Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => $secretKey,
            'response' => $token,
        ])->json();
    }

    /**
     * Forgot password for a user.
     */
    public function forgotPassword(ForgotRequest $request): JsonResponse
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
    {
        $response = $this->authService->resetPassword();

        return handleResponse($response);
    }

<<<<<<< HEAD
    public function me()
=======
    /**
     * Get the authenticated User.
     */
    public function me(): JsonResponse
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
    {
        $user =
            $this->currentUser->user_catalogue->id == User::ROLE_CUSTOMER
            ?
            new ClientUserResource($this->currentUser)
            :
            new UserResource($this->currentUser);

        return response()->json($user, ResponseEnum::OK);
    }

<<<<<<< HEAD
    public function refreshToken()
=======
    /**
     * Refresh the token.
     */
    public function refreshToken(): JsonResponse
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
    {
        return $this->respondWithToken(auth()->refresh(), 'Token đã được thay đổi');
    }

<<<<<<< HEAD
    private function respondWithToken($token, $message, $user = null)
=======
    /**
     * Generate a response with a token.
     */
    private function respondWithToken(string $token, string $message, ?User $user = null): JsonResponse
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
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

<<<<<<< HEAD
    public function logout()
=======
    /**
     * Logs the user out of the application.
     */
    public function logout(): JsonResponse
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
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
        if ( ! $phone) {
            return errorResponse('Vui lòng nhập số điện thoại.', true);
        }
        $user = User::where('phone', $phone)->first();
        if ( ! $user) {
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
