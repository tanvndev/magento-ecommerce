<?php

namespace App\Classes;

class Vnpay
{
    public static function payment($order)
    {
        $vnpConfig = config('apps.paymentConfig')['vnpay'];
        //Config
        $vnp_Url = $vnpConfig['vnp_Url'];
        $vnp_TmnCode = $vnpConfig['vnp_TmnCode'];
        $vnp_HashSecret = $vnpConfig['vnp_HashSecret'];
        $vnp_ReturnUrl = $vnpConfig['vnp_ReturnUrl'];

        $locale = 'vn';

        // Tạo một mảng chứa thông tin cần thiết
        $amount = $order['cart']['total'] - $order['promotion']['discount'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => $locale,
            "vnp_OrderInfo" => $order['description'] ?? 'Thanh toan don hang ' . $order['code'] . ' qua VNPAY.',
            "vnp_OrderType" => 'billpayment',
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $order['code'],
        );

        // Thêm thông tin nhưng không bắt buộc
        if (isset($order['bank_code']) && $order['bank_code'] != "") {
            $inputData['vnp_BankCode'] = $order['bank_code'];
        }

        if (isset($order['txt_bill_state']) && $order['txt_bill_state'] != "") {
            $inputData['vnp_Bill_State'] = $order['txt_bill_state'];
        }


        ksort($inputData);

        // Xây dựng chuỗi hash
        $hashdata = http_build_query($inputData, '', '&');

        $vnp_Url = $vnp_Url . "?" . $hashdata;

        // Thêm vnp_SecureHash vào URL nếu có vnp_HashSecret
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = [
            'code' => '00',
            'message' => 'success',
            'url' => $vnp_Url,
        ];

        return $returnData;
    }
}
