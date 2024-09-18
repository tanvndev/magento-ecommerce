<?php

namespace App\Services\Interfaces\Order;

interface OrderServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);
}
