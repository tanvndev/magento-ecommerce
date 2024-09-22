<?php

namespace App\Services\Interfaces\Attribute;

interface AttributeValueServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function destroy($id);
}
