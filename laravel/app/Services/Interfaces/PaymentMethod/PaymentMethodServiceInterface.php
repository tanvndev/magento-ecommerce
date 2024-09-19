<?php

declare(strict_types=1);

namespace App\Services\Interfaces\PaymentMethod;

interface PaymentMethodServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);
}
