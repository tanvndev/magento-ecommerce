<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function emailRegisterVerify(Request $request, $id)
    {
        $user = User::find($id);

        //   Kiem tra co email chua
        if (! $user) {
            return redirect()->route('notifications', ['boolean' => 0, 'messages' => 'Tài khoản người dùng chưa được đăng ký vui lòng đăng ký.']);
        }

        // Kime tra xem email da duoc xac thuc chua
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('notifications', ['boolean' => 0, 'messages' => 'Email của người dùng đã được xác thực trước đó.']);
        }

        // Kiem tra het han dang ky
        if (! $request->hasValidSignature()) {
            $user->delete();

            return $this->fail($user);
        }

        // Kiem tra co id nguoi dung co hop le khong
        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            return $this->fail($user);
        }

        //Kiem tra co hash co hop le khong
        if (! hash_equals((string) $request->query('hash'), sha1($user->getEmailForVerification()))) {
            return $this->fail($user);
        }

        // Xac thuc nguoi dung
        $user->markEmailAsVerified();

        return redirect()->route('notifications', ['boolean' => 1, 'messages' => 'Chúc mừng bạn đã xác nhận đăng ký thành công xin vui lòng đăng nhập tài khoản.']);
    }

    private function fail($user)
    {
        $user->delete();

        return redirect()->route('notifications', ['boolean' => 0, 'messages' => 'Đường dẫn xác nhận không hợp lệ hoặc đã hết hạn.']);
    }
}
