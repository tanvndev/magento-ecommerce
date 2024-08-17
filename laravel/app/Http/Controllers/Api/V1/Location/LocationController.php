<?php

namespace App\Http\Controllers\Api\V1\Location;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Location\DistrictRepositoryInterface;
use App\Repositories\Interfaces\Location\ProvinceRepositoryInterface;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $provinceRepository;

    protected $districtRepository;

    public function __construct(
        ProvinceRepositoryInterface $provinceRepository,
        DistrictRepositoryInterface $districtRepository
    ) {
        $this->provinceRepository = $provinceRepository;
        $this->districtRepository = $districtRepository;
    }

    public function getProvinces()
    {
        $data = $this->provinceRepository->all();

        return successResponse('Get provinces successfully', $data);
    }

    public function getLocation(Request $request)
    {
        $locationId = $request->location_id;
        $target = $request->target;
        $response = [];

        if ($target == 'districts') {
            $response = $this->provinceRepository->findByWhere(['code' => ['=', $locationId]], ['code', 'name'], ['districts']);
            $response->districts;
        } else {
            $response = $this->districtRepository->findByWhere(['code' => ['=', $locationId]], ['code', 'name'], ['wards']);
            $response->wards;
        }

        return successResponse('Get province successfully.', $response);
    }
}
