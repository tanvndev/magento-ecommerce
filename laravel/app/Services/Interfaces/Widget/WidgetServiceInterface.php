<?php

namespace App\Services\Interfaces\Widget;

interface WidgetServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function destroy($id);

    public function updateStatus();

    public function updateStatusMultiple();

    public function getWidget();
}
