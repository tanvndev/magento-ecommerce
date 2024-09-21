<?php



namespace App\Http\Controllers\Api\V1\Order;

use App\Classes\Momo;
use App\Classes\Paypal;
use App\Classes\Vnpay;
use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentMethod;
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
        if (empty($order)) {
            return errorResponse(__('messages.order.error.create'));
        }

        $response = $this->handlePaymentMethod($order);

        return handleResponse($response, ResponseEnum::CREATED);
    }

    private function handlePaymentMethod(Order $order)
    {
        switch ($order->payment_method_id) {
            case PaymentMethod::VNPAY_ID:
                $response = Vnpay::payment($order);

                break;
            case PaymentMethod::MOMO_ID:
                $response = Momo::payment($order);

                break;
                // case 'paypal_payment':
                //     $response = Paypal::payment($order);

                //     break;

            default:
                // code...
                break;
        }

        return $response;
    }
}
