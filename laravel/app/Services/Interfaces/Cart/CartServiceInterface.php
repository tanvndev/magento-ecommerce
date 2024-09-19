<?php

declare(strict_types=1);

namespace App\Services\Interfaces\Cart;

interface CartServiceInterface
{
    public function getCart();

    public function createOrUpdate($request);

    public function deleteOneItem($request);

    public function cleanCart();

    public function handleSelected($request);
}
