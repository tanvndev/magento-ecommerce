<?php

namespace App\Services\Interfaces\Permission;

interface PermissionServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function destroy($id);

    public function deleteMultiple();
}
