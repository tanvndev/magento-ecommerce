<?php

namespace App\Services\Interfaces\Order;

interface OrderServiceInterface
{
    // public function paginate();

    public function create();

    public function update(string $id);

    public function updatePayment(string $id, array $payload);

    public function getOrder(string $orderCode);
}
