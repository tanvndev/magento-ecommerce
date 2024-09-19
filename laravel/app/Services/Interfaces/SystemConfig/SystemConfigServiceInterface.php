<?php

declare(strict_types=1);

namespace App\Services\Interfaces\SystemConfig;

interface SystemConfigServiceInterface
{
    public function all();

    public function update();
}
