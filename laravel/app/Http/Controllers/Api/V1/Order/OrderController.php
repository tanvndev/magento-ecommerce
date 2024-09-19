<?php



namespace App\Http\Controllers\Api\V1\Order;

use App\Classes\Momo;
use App\Classes\Paypal;
use App\Classes\Vnpay;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\Order\OrderServiceInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(
        OrderServiceInterface $orderService,
    ) {
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        $order = $this->orderService->create();
        dd($order);
        // if (!empty($order)) {
        //     $request->session()->put('orderSuccess', $order);

        //     $response = $this->handlePaymentMethod($order);
        //     if ($response['code'] == 00) {
        //         return redirect()->away($response['url']);
        //     }

        //     return redirect()->route('cart.success')->with('toast_success', 'Đặt hàng thành công.');
        // }
        // return redirect()->back()->with('toast_error', 'Đặt hàng thất bại, vui lòng đặt lại!');
    }

    private function handlePaymentMethod($order = null)
    {

        switch ($order['payment_method']) {
            case 'vnp_payment':
                $response = Vnpay::payment($order);

                break;
            case 'momo_payment':
                $response = Momo::payment($order);

                break;
            case 'paypal_payment':
                $response = Paypal::payment($order);

                break;

            default:
                // code...
                break;
        }

        return $response;
    }
}
