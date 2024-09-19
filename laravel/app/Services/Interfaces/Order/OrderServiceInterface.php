<?php

declare(strict_types=1);

namespace App\Services\Interfaces\Order;

interface OrderServiceInterface
{
    // public function paginate();

    public function create();

    public function update($id);
}
