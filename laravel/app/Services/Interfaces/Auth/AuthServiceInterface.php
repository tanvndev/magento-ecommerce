<?php

namespace App\Services\Interfaces\Auth;

/**
 * Interface UserCatalogueServiceInterface
 */
interface AuthServiceInterface
{
    public function register();

    public function resetPassword();
}
