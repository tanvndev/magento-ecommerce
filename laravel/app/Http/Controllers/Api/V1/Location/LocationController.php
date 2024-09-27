<?php

namespace App\Http\Controllers\Api\V1\Location;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Location\DistrictRepositoryInterface;
use App\Repositories\Interfaces\Location\ProvinceRepositoryInterface;
use App\Services\Interfaces\Location\LocationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct(
        protected ProvinceRepositoryInterface $provinceRepository,
        protected DistrictRepositoryInterface $districtRepository,
        protected LocationServiceInterface $locationService
    ) {}

    /**
     * Get all provinces.
     *
     * @return JsonResponse
     */
    public function getProvinces()
    {
        $data = $this->provinceRepository->all();

        return successResponse('Get provinces successfully', $data, true);
    }

    /**
     * Get location by id.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocation(Request $request): JsonResponse
    {
        $locationId = $request->location_id;
        $target = $request->target;
        $response = [];

        if ($target == 'districts') {
            $response = $this->provinceRepository->findByWhere(
                ['code' => ['=', $locationId]],
                ['code', 'name'],
                ['districts']
            );
            $response->districts;
        } else {
            $response = $this->districtRepository->findByWhere(
                ['code' => ['=', $locationId]],
                ['code', 'name'],
                ['wards']
            );
            $response->wards;
        }

        return successResponse('Get province successfully.', $response, true);
    }

    /**
     * Get location by address.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocationByAddress(Request $request): JsonResponse
    {
        $addressData = $request->addressData;

        if (empty($addressData)) {
            return errorResponse('Get location failed.');
        }

        $response = $this->locationService->getLocationByAddress($addressData['address']);

        return successResponse('Get location successfully.', $response, true);
    }
}
