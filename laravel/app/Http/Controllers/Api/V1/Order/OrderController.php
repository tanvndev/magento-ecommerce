<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\Classes\Momo;
use App\Classes\Paypal;
use App\Classes\Vnpay;
use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
<<<<<<< HEAD
=======
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
use App\Http\Resources\Order\Client\ClientOrderCollection;
use App\Http\Resources\Order\Client\ClientOrderResource;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Services\Interfaces\Order\OrderServiceInterface;
<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use Illuminate\Http\JsonResponse;
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(
        OrderServiceInterface $orderService,
    ) {
        $this->orderService = $orderService;
    }

<<<<<<< HEAD
    public function store(Request $request)
=======
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $order = $this->orderService->paginate();

        $data = new OrderCollection($order ?? []);

        return successResponse('', $data, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $orderCode
     */
    public function show($orderCode): JsonResponse
    {
        $order = $this->orderService->getOrder($orderCode);

        $data = is_null($order) ? null : new OrderResource($order ?? []);

        return successResponse('', $data, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): JsonResponse
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
    {
        $order = $this->orderService->create();
        if (empty($order) || $order['status'] == 'error') {
            return errorResponse(__('messages.order.error.create'), true);
        }

        $response = $this->handlePaymentMethod($order);

        return handleResponse($response, ResponseEnum::CREATED);
    }

<<<<<<< HEAD
    private function handlePaymentMethod(Order $order)
=======
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id): JsonResponse
    {
        $response = $this->orderService->update($id);

        return handleResponse($response);
    }

    /**
     * Handle order payment.
     *
     * @param  string  $orderCode  The order code.
     */
    public function handleOrderPayment(string $orderCode): JsonResponse
    {
        $order = $this->orderService->getOrderUserByCode($orderCode);

        if ( ! $order) {
            $response = [
                'status'   => 'error',
                'messages' => __('messages.order.error.create'),
                'url'      => env('NUXT_APP_URL') . '/payment-fail',
            ];

            return handleResponse($response);
        }

        $response = $this->handlePaymentMethod($order);

        return handleResponse($response);
    }

    /**
     * Handle payment method.
     */
    private function handlePaymentMethod($order)
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
    {
        switch ($order->payment_method_id) {
            case PaymentMethod::VNPAY_ID:
                $response = Vnpay::payment($order);

                break;
            case PaymentMethod::MOMO_ID:
                $response = Momo::payment($order);

                break;
            case 'paypal_payment':
                $response = Paypal::payment($order);

                break;
            case PaymentMethod::COD_ID:
                $response = [
                    'status'   => 'success',
                    'messages' => __('messages.order.success.create'),
                    'url'      => env('NUXT_APP_URL') . '/order-success?code=' . $order->code,
                ];
            default:
                // code...
                break;
        }

        return $response;
    }

    public function getOrder(string $orderCode)
    {
        $order = $this->orderService->getOrder($orderCode);

        $data = is_null($order) ? null : new ClientOrderResource($order ?? []);

        return successResponse('', $data);
    }

    public function getOrderByUser()
    {
        $orders = $this->orderService->getOrderByUser();

        $data = new ClientOrderCollection($orders);

        return successResponse('', $data);
    }
}
