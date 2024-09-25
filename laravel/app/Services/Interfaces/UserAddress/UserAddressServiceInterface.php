<?php

namespace App\Services\Interfaces\UserAddress;

interface UserAddressServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function destroy($id);

    public function getAddressByUserId();
}
