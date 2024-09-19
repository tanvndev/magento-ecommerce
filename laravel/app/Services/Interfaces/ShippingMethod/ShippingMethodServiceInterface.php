<?php

declare(strict_types=1);

namespace App\Services\Interfaces\ShippingMethod;

interface ShippingMethodServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);
}
