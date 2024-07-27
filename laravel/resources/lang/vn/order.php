<?php
return [
    'confirm' => [
        'pending' => [
            'title' => 'Đang chờ xác nhận đơn hàng',
            'icon' => 'icofont-info',
            'color' => 'warning'
        ],
        'success' => [
            'title' => 'Đơn hàng đã được xác nhận',
            'icon' => 'icofont-check',
            'color' => 'success'
        ],
        'cancel' => [
            'title' => 'Đơn hàng đã hủy',
            'icon' => 'icofont-close',
            'color' => 'danger'
        ],

    ],
    'delivery' => [
        'pending' => [
            'title' => 'Chưa giao hàng',
            'color' => 'danger'
        ],
        'processing' => [
            'title' => 'Đang giao hàng',
            'color' => 'info'
        ],
        'success' => [
            'title' => 'Đã giao hàng',
            'color' => 'success'
        ],

    ],
    'payment' => [
        'unpaid' => [
            'title' => 'Chưa thanh toán',
            'color' => 'danger'
        ],
        'paid' => [
            'title' => 'Đã thanh toán',
            'color' => 'success'
        ],


    ],

];
