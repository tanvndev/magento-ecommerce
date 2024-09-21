<?php



namespace App\Services\Interfaces\Cart;

interface CartServiceInterface
{
    public function getCart($sessionId = null);

    public function createOrUpdate($request, $sessionId = null);

    public function deleteOneItem($id, $sessionId = null);

    public function cleanCart($sessionId = null);

    public function handleSelected($request, $sessionId = null);

    public function deleteCartSelected($sessionId = null);
}
