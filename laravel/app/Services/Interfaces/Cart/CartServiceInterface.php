<?php

namespace App\Services\Interfaces\Cart;

interface CartServiceInterface{
public function getCart();

public function StoreOrUpdate($request);

public function deleteOneItem($request);

public function deleteAllCart();


}

?>
