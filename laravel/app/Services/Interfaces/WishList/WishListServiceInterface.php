<?php

namespace App\Services\Interfaces\WishList;

interface WishListServiceInterface
{
    public function paginate();

    public function create();

    public function destroy($id);

    public function destroyAll();

    public function getWishListByUserId();
}
