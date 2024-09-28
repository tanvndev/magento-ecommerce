<?php

namespace App\Services\Interfaces\Slider;

interface SliderServiceInterface
{
    public function paginate();

    public function create();

    public function update($id);

    public function destroy($id);

    public function getAllSlider();
}
