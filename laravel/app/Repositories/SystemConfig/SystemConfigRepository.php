<?php

namespace App\Repositories\SystemConfig;

use App\Models\SystemConfiguration;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\SystemConfig\SystemConfigRepositoryInterface;

class SystemConfigRepository extends BaseRepository implements SystemConfigRepositoryInterface
{
    public $model;

    public function __construct(SystemConfiguration $model)
    {
        $this->model = $model;
    }
}
