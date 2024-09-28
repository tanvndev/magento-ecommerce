<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;
use App\Services\Interfaces\Order\OrderServiceInterface;
use Exception;
use Illuminate\Http\Request;

class MomoController extends Controller
{
    private $orderRepository;

    private $orderService;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderServiceInterface $orderService
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    public function handleReturnUrl(Request $request)
    {
        $configMomo = config('apps.paymentConfig.momo');
        $secretKey = $configMomo['secretKey'];
        $accessKey = $configMomo['accessKey'];
        $inputData = $request->query();

        if ( ! empty($inputData)) {
            $rawHash = 'accessKey=' . $accessKey;
            $rawHash .= '&amount=' . $inputData['amount'];
            $rawHash .= '&extraData=' . $inputData['extraData'];
            $rawHash .= '&message=' . $inputData['message'];
            $rawHash .= '&orderId=' . $inputData['orderId'];
            $rawHash .= '&orderInfo=' . $inputData['orderInfo'];
            $rawHash .= '&orderType=' . $inputData['orderType'];
            $rawHash .= '&partnerCode=' . $inputData['partnerCode'];
            $rawHash .= '&payType=' . $inputData['payType'];
            $rawHash .= '&requestId=' . $inputData['requestId'];
            $rawHash .= '&responseTime=' . $inputData['responseTime'];
            $rawHash .= '&resultCode=' . $inputData['resultCode'];
            $rawHash .= '&transId=' . $inputData['transId'];

            $partnerSignature = hash_hmac('sha256', $rawHash, $secretKey);
            $m2signature = $inputData['signature'];

            if ($m2signature == $partnerSignature) {
                if ($inputData['resultCode'] == '0') {

                    $request->session()->put('paymentReturn',  $inputData);
                    $request->session()->put('templatePayment',  'clients.includes.momo');

                    $this->handleMomoIpn($inputData);

                    return redirect()->route('cart.success')->with('toast_success', 'Đặt hàng thành công.');
                }
            }
        }
        // Xoa orderSuccess
        $request->session()->forget('orderSuccess');

        return redirect()->route('checkout')->with('toast_error', 'Đặt hàng thất bại, vui lòng thử lại!');
    }

    private function handleMomoIpn($get)
    {
        // Tam thoi de private khi nao chuyen qua thanh toan live se chuyen thanh public va cau hinh kieu khac
        $configMomo = config('apps.paymentConfig.momo');
        $secretKey = $configMomo['secretKey'];
        $accessKey = $configMomo['accessKey'];

        if ( ! empty($get)) {
            $response = [];
            try {
                $rawHash = 'accessKey=' . $accessKey;
                $rawHash .= '&amount=' . $get['amount'];
                $rawHash .= '&extraData=' . $get['extraData'];
                $rawHash .= '&message=' . $get['message'];
                $rawHash .= '&orderId=' . $get['orderId'];
                $rawHash .= '&orderInfo=' . $get['orderInfo'];
                $rawHash .= '&orderType=' . $get['orderType'];
                $rawHash .= '&partnerCode=' . $get['partnerCode'];
                $rawHash .= '&payType=' . $get['payType'];
                $rawHash .= '&requestId=' . $get['requestId'];
                $rawHash .= '&responseTime=' . $get['responseTime'];
                $rawHash .= '&resultCode=' . $get['resultCode'];
                $rawHash .= '&transId=' . $get['transId'];

                $partnerSignature = hash_hmac('sha256', $rawHash, $secretKey);
                $m2signature = $get['signature'];

                $partnerSignature = hash_hmac('sha256', $rawHash, $secretKey);

                $order = $this->orderRepository->findByWhere(['code' => ['=', $get['orderId']]]);

                if ($m2signature == $partnerSignature) {
                    if ($get['resultCode'] == '0') {
                        $result = '<div class="alert alert-success">Capture Payment Success</div>';
                        $payload['payment'] = 'paid';
                    } else {
                        $payload['payment'] = 'unpaid';
                        $result = '<div class="alert alert-danger">' . $get['message'] . '</div>';
                    }
                } else {
                    $payload['payment'] = 'unpaid';
                    $result = '<div class="alert alert-danger">This transaction could be hacked, please check your signature and returned signature</div>';
                }
                $this->orderService->update($order->id, $payload);
            } catch (Exception $e) {
                echo $response['message'] = $e;
            }

            $debugger = [];
            $debugger['rawData'] = $rawHash;
            $debugger['momoSignature'] = $m2signature;
            $debugger['partnerSignature'] = $partnerSignature;

            if ($m2signature == $partnerSignature) {
                $response['message'] = 'Received payment result success';
            } else {
                $response['message'] = 'ERROR! Fail checksum';
            }
            $response['debugger'] = $debugger;
            // echo json_encode($response);
        }
    }

    // if (!empty($_POST)) {
    //     $response = array();
    //     try {
    //         $partnerCode = $_POST["partnerCode"];
    //         $accessKey = $_POST["accessKey"];
    //         $serectkey = '';
    //         $orderId = $_POST["orderId"];
    //         $localMessage = $_POST["localMessage"];
    //         $message = $_POST["message"];
    //         $transId = $_POST["transId"];
    //         $orderInfo = $_POST["orderInfo"];
    //         $amount = $_POST["amount"];
    //         $errorCode = $_POST["errorCode"];
    //         $responseTime = $_POST["responseTime"];
    //         $requestId = $_POST["requestId"];
    //         $extraData = $_POST["extraData"];
    //         $payType = $_POST["payType"];
    //         $orderType = $_POST["orderType"];
    //         $extraData = $_POST["extraData"];
    //         $m2signature = $_POST["signature"]; //MoMo signature

    //         //Checksum
    //         $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
    //             "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
    //             "&payType=" . $payType . "&extraData=" . $extraData;

    //         $partnerSignature = hash_hmac("sha256", $rawHash, 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa');

    //         if ($m2signature == $partnerSignature) {
    //             if ($errorCode == '0') {
    //                 $result = '<div class="alert alert-success">Capture Payment Success</div>';
    //             } else {
    //                 $result = '<div class="alert alert-danger">' . $message . '</div>';
    //             }
    //         } else {
    //             $result = '<div class="alert alert-danger">This transaction could be hacked, please check your signature and returned signature</div>';
    //         }

    //     } catch (Exception $e) {
    //         echo $response['message'] = $e;
    //     }

    //     $debugger = array();
    //     $debugger['rawData'] = $rawHash;
    //     $debugger['momoSignature'] = $m2signature;
    //     $debugger['partnerSignature'] = $partnerSignature;

    //     if ($m2signature == $partnerSignature) {
    //         $response['message'] = "Received payment result success";
    //     } else {
    //         $response['message'] = "ERROR! Fail checksum";
    //     }
    //     $response['debugger'] = $debugger;
    //     echo json_encode($response);
    // }

}
