<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;
use App\Services\Interfaces\Order\OrderServiceInterface;
use Exception;
use Illuminate\Http\Request;

class VnpController extends Controller
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
        // Lấy cấu hình từ config
        $vnpConfig = config('apps.payment-config')['vnpay'];
        $vnp_HashSecret = $vnpConfig['vnp_HashSecret'];
        $vnp_SecureHash = $request->input('vnp_SecureHash');

        // Lấy tất cả các giá trị từ query string có tiền tố 'vnp_'
        $inputData = $request->query();
        $filteredData = [];

        foreach ($inputData as $key => $value) {
            if (substr($key, 0, 4) == 'vnp_') {
                $filteredData[$key] = $value;
            }
        }

        // Loại bỏ 'vnp_SecureHash' khỏi dữ liệu để hash
        unset($filteredData['vnp_SecureHash']);

        // Sắp xếp theo key và xây dựng chuỗi hash
        ksort($filteredData);

        $i = 0;
        $hashData = '';
        foreach ($filteredData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Kiểm tra tính hợp lệ của chữ ký
        if ($secureHash == $vnp_SecureHash) {
            if ($request->input('vnp_ResponseCode') == '00') {
                return $this->handleVnpIpn($inputData);
            }
        }

        return redirect()->away(env('NUXT_APP_URL') . '/payment-fail');
    }

    private function handleVnpIpn($get)
    {
        // Tam thoi de private khi nao chuyen qua thanh toan live se chuyen thanh public va cau hinh kieu khac

        /* Payment Notify
            * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
            * Các bước thực hiện:
            * Kiểm tra checksum
            * Tìm giao dịch trong database
            * Kiểm tra số tiền giữa hai hệ thống
            * Kiểm tra tình trạng của giao dịch trước khi cập nhật
            * Cập nhật kết quả vào Database
            * Trả kết quả ghi nhận lại cho VNPAY
        */

        // Lấy cấu hình từ config
        $vnpConfig = config('apps.payment-config')['vnpay'];
        $vnp_HashSecret = $vnpConfig['vnp_HashSecret'];

        $inputData = [];
        $returnData = [];

        foreach ($get as $key => $value) {
            if (substr($key, 0, 4) == 'vnp_') {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = '';
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.

        $orderCode = $inputData['vnp_TxnRef'];

        try {
            //Check Orderid
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);

                $order = $this->orderRepository->findByWhere(['code' => $orderCode]);
                $orderFinalAmount = $order->final_price;

                if ($order != null) {
                    if ($orderFinalAmount <= $vnp_Amount) { //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng.
                        //$order["Amount"] == $vnp_Amount
                        if (
                            $order->payment_status != Order::PAYMENT_STATUS_PAID &&
                            $order->payment_status == Order::PAYMENT_STATUS_UNPAID
                        ) {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                $payload['payment_status'] = Order::PAYMENT_STATUS_PAID; // Trạng thái thanh toán thành công
                            } else {
                                $payload['payment_status'] = Order::PAYMENT_STATUS_UNPAID; // Trạng thái thanh toán thất bại / lỗi
                            }

                            $payload['payment_detail'] = $inputData;
                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB

                            $this->orderService->updatePayment($order->id, $payload);

                            //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    } else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }

        if ($returnData['RspCode'] == '00') {
            return redirect()->away(env('NUXT_APP_URL') . '/order-success?code=' . $orderCode);
        }

        return redirect()->away(env('NUXT_APP_URL') . '/payment-fail');


        //Trả lại VNPAY theo định dạng JSON
        // echo json_encode($returnData);
    }
}
