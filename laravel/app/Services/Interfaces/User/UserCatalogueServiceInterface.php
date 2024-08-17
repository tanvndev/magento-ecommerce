<?php

namespace App\Services\Interfaces\User;

/**
 * Interface UserCatalogueServiceInterface
 */
interface UserCatalogueServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function destroy($id);

    public function updateStatus();

    public function updateStatusMultiple();

    public function deleteMultiple();

    public function updatePermissions();
}
