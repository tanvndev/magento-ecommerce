<?php
return [
    'method' => [
        [
            'name' => 'cod_payment',
            'title' => 'Thanh toán khi nhận hàng (COD)',
            'image' => '/public/userfiles/image/other/9198191.png',
            'description' => 'Thanh toán bằng tiền mặt khi giao hàng.',
        ],
        [
            'name' => 'vnpay_payment',
            'title' => 'Thanh toán qua ví điện tử VNPAY',
            'image' => '/public/userfiles/image/other/Logo-VNPAY-QR-1.png',
            'description' => 'Thanh toán qua ví điện tử VNPAY; bạn có thể thanh toán bằng thẻ tín dụng nếu bạn không có
            VNPAY tài khoản.',
        ],
        [
            'name' => 'momo_payment',
            'title' => 'Thanh toán qua ví điện tử MOMO',
            'image' => '/public/userfiles/image/other/momo_icon.png',
            'description' => 'Thanh toán qua ví điện tử MOMO; bạn có thể thanh toán bằng thẻ tín dụng nếu bạn không có
            MOMO tài khoản.',
        ],
        [
            'name' => 'paypal_payment',
            'title' => 'Thanh toán qua ví điện tử PAYPAL',
            'image' => 'assets/clients/images/others/payment.png',
            'description' => 'Thanh toán qua ví điện tử PAYPAL; bạn có thể thanh toán bằng thẻ tín dụng nếu bạn không có
            PAYPAL tài khoản.',
        ],
    ],
    'transportMethod' => [
        [
            'name' => 'economicalDelivery',
            'title' => 'Giao hàng tiết kiệm',
            'cost' => 25000
        ],
        [
            'name' =>  'fastdelivery',
            'title' => 'Giao hàng nhanh',
            'cost' => 35000,
        ],
        [
            'name' => 'expressDelivery',
            'title' => 'Giao hàng hỏa tốc',
            'cost' => 105000,
        ],
    ]

];
