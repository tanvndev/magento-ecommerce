<?php

namespace App\Services\Interfaces\Cart;

interface CartServiceInterface
{
    public function getCart();

    public function createOrUpdate($request);

    public function deleteOneItem($request, $id);

    public function cleanCart();

    public function handleSelected($request);
}
