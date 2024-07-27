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
        DB::beginTransaction();
        try {
            $user = null;
            // Kiem tra xem nguoi dung da dang ky truoc do chua
            $user = $this->userRepository->findByWhere(
                [
                    'email' => ['=', request()->email],
                ]
            );

            if (!empty($user) && $user->hasVerifiedEmail()) {
                return [
                    'status' => 'error',
                    'messages' => 'Email đã được đăng ký vui lòng đăng nhập.',
                    'data' => null
                ];
            }
            if (!empty($user) && !$user->hasVerifiedEmail()) {
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
            DB::commit();

            return [
                'status' => 'success',
                'messages' => 'Người dùng đã đăng ký thành công. Vui lòng kiểm tra email của bạn để xác nhận đăng ký.',
                'data' => null
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Người dùng đã đăng ký thất bại.',
                'data' => null
            ];
        }
    }
    public function resetPassword()
    {
        DB::beginTransaction();
        try {
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
            DB::commit();

            return [
                'status' => 'success',
                'messages' => 'Chúng tôi đã gửi mật khẩu mới vào email của bạn vui lòng kiểm tra.',
                'data' => null
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Đặt lại mật khẩu thất bại.',
                'data' => null
            ];
        }
    }
}
