<?php

declare(strict_types=1);

namespace App\Services\Interfaces\Voucher;

interface VoucherServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function destroy($id);

    public function getAllVoucher();
}
