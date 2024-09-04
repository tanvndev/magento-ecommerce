<?php

namespace App\Services\Interfaces\ShippingMethod;

interface ShippingMethodServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function updateStatus();

    public function updateStatusMultiple();
}
