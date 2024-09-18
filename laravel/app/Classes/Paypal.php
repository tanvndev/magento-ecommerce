<?php

namespace App\Classes;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class Paypal
{
    public static function payment($order)
    {
        $provider = new PayPalClient;
        $provider = \PayPal::setProvider();
        $accessToken = $provider->getAccessToken();

        $currencyCode = 'USD';
        $orderAmount = ($order['cart']['total'] - $order['promotion']['discount']);

        $paypalValue = convertVndTo($orderAmount, $currencyCode);

        $data = [
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success', ['order_id' => $order['id']]),
                "cancel_url" => route('paypal.cancel'),
            ],

            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => $currencyCode,
                        "value" => $paypalValue
                    ]
                ]
            ],



        ];

        $response = $provider->createOrder($data);
        $returnData = [
            'code' => '00',
            'message' => 'success',
        ];

        foreach ($response['links'] as $key => $value) {
            if ($value['rel'] == 'approve') {
                $returnData['url'] = $value['href'];
            }
        }

        return $returnData;
    }
}
