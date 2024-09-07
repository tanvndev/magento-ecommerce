<?php

return [
    'create' => [
        'success' => 'Tạo mới bản ghi thành công.',
        'error' => 'Tạo mới bản ghi thất bại.',
    ],
    'update' => [
        'success' => 'Cập nhật bản ghi thành công.',
        'error' => 'Cập nhật bản ghi thất bại.',
    ],
    'show' => [
        'success' => 'Hiển thị bản ghi thành công.',
        'error' => 'Không thể hiển thị bản ghi.',
    ],
    'delete' => [
        'success' => 'Xóa bản ghi thành công.',
        'error' => 'Xóa bản ghi thất bại.',
    ],
    'publish' => [
        'success' => 'Cập nhập trạng thái thành công.',
        'error' => 'Cập nhập trạng thái thất bại.',
    ],
    'upload' => [
        'create' => [
            'success' => 'Tải lên tệp mới thành công.',
            'error' => 'Tải lên tệp mới thất bại.',
        ],
        'delete' => [
            'success' => 'Xóa tệp thành công.',
            'error' => 'Xóa tệp thất bại.',
        ],
    ],
    'cart' => [
        'success'   => [
            'create'            => 'Thêm giỏ hàng thành công.',
            'update'            => 'Cập nhật giỏ hàng thành công.',
            'delete'            => 'Xóa thành công.',
            'clear'             => 'Xóa thành công giỏ hàng.',
        ],
        'error'     => [
            'not_found'         => 'Sản phẩm không tồn tại trên hệ thống!',
            'max'               => 'Số lượng trong kho không đủ!',
            'min'               => 'Số lượng trong giỏ hàng không đủ!',
            'delete'            => 'Xóa thất bại!',
            "item_not_found"    => "Sản phẩm này không có trong giỏ hàng!",
            'cart_not_found'    => "Người dùng chưa có giỏ hàng!"
        ],
    ],
    'auth' => [
        'register' => [
            'success' => 'Người dùng đã đăng ký thành công. Vui lòng kiểm tra email của bạn để xác nhận đăng ký.',
            'error' => 'Người dùng đã đăng ký thành công vui lòng kiểm tra lại.',
            'email_verified' => 'Email đã xác nhận đăng ký vui lòng đăng nhập.',
        ],
        'reset_password' => [
            'success' => 'Chúng tôi đã gửi mật khẩu mới vào email của bạn vui lòng kiểm tra.',
            'error' => 'Đặt lại mật khẩu thất bại.',
        ],
    ],
];
