<?php

namespace App\Services\Interfaces\WishList;

interface WishListServiceInterface
{
    public function paginate();

    public function create();

    // public function update($id);

    public function destroy($id);
}
