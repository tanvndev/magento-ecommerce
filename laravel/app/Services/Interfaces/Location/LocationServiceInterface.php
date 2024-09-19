<?php

declare(strict_types=1);

namespace App\Services\Interfaces\Location;

interface LocationServiceInterface
{
    public function getLocationByAddress($address);
}
