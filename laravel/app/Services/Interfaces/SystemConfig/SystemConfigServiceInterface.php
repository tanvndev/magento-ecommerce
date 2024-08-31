<?php

namespace App\Services\Interfaces\SystemConfig;

interface SystemConfigServiceInterface
{
    public function all();

    public function create();

    public function update($id);

    public function destroy($id);
}
