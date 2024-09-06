<?php

namespace App\Services\Interfaces\Cart;

interface CartServiceInterface{
public function getCart();

public function CreateOrUpdate($request);

public function deleteOneItem($request);

public function deleteAllCart();


}

?>
