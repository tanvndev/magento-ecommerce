<?php

declare(strict_types=1);

namespace App\Services\Interfaces\Auth;

/**
 * Interface UserCatalogueServiceInterface
 */
interface AuthServiceInterface
{
    public function register();

    public function resetPassword();
}
