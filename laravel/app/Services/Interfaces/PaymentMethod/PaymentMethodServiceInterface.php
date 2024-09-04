<?php

namespace App\Services\Interfaces\PaymentMethod;

interface PaymentMethodServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function updateStatus();

    public function updateStatusMultiple();
}
