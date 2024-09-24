<?php

return [
    'vnpay' => [
        'vnp_Url'        => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
        'vnp_TmnCode'    => env('VNPAY_TMN_CODE'),
        'vnp_HashSecret' => env('VNPAY_HASH_SECRET'),
        'vnp_ReturnUrl'  => env('APP_URL') . '/return/vnpay',
        'vnp_apiUrl'     => 'https://sandbox.vnpayment.vn/merchant_webapi/merchant.html',
        'apiUrl'         => 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction',
    ],

    'momo' => [
        'endpoint'    => 'https://test-payment.momo.vn/v2/gateway/api/create',
        'partnerCode' => env('MOMO_PARTNER_CODE'),
        'accessKey'   => env('MOMO_ACCESS_KEY'),
        'secretKey'   => env('MOMO_SECRET_KEY'),
        'redirectUrl' => env('APP_URL') . '/return/momo',
        'ipnUrl'      => env('APP_URL') . '/return/momo_ipn',
    ],

];
