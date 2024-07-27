<?php

namespace App\Services\Interfaces\Auth;

/**
 * Interface UserCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface AuthServiceInterface
{
    public function register();
    public function resetPassword();
}
