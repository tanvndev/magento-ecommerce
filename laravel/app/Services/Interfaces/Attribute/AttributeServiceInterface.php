<?php

declare(strict_types=1);

namespace App\Services\Interfaces\Attribute;

interface AttributeServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function destroy($id);
}
