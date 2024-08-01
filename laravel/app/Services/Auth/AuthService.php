<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Auth;

use App\Events\AuthForgotEvent;
use App\Events\AuthRegisteredEvent;
use App\Repositories\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService extends BaseService implements AuthServiceInterface
{
    protected $userRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }



    public function register()
    {
        return $this->executeInTransaction(function () {
            $user = null;
            // Kiem tra xem nguoi dung da dang ky truoc do chua
            $user = $this->userRepository->findByWhere(
                [
                    'email' => ['=', request()->email],
                ]
            );

            if (!empty($user)) {
                if ($user->hasVerifiedEmail()) {
                    return errorResponse('Email đã xác nhận đăng ký vui lòng đăng nhập.');
                }
                $user->delete();
            }

            $user = $this->userRepository->create([
                'fullname' => request()->fullname,
                'user_catalogue_id' => 3,
                'email' => request()->email,
                'ip' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'password' => Hash::make(request()->password),
            ]);


            // Send email verification notification
            event(new AuthRegisteredEvent($user));

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    public function resetPassword()
    {
        return $this->executeInTransaction(function () {
            $user = $this->userRepository->findByWhere(
                [
                    'email' => ['=', request()->email],
                ]
            );
            $randomPassword = generateStrongPassword();
            $user->password = Hash::make($randomPassword);
            $user->save();
            $user->newPassword = $randomPassword;

            // Send email verification notification
            event(new AuthForgotEvent($user));
            return successResponse('Chúng tôi đã gửi mật khẩu mới vào email của bạn vui lòng kiểm tra.');
        }, 'Đặt lại mật khẩu thất bại.');
    }
}
