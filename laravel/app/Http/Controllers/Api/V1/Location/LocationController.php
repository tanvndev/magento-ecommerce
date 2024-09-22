<?php



namespace App\Http\Controllers\Api\V1\Location;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Location\DistrictRepositoryInterface;
use App\Repositories\Interfaces\Location\ProvinceRepositoryInterface;
use App\Services\Interfaces\Location\LocationServiceInterface;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $provinceRepository;

    protected $districtRepository;

    protected $locationService;

    public function __construct(
        ProvinceRepositoryInterface $provinceRepository,
        DistrictRepositoryInterface $districtRepository,
        LocationServiceInterface $locationService
    ) {
        $this->provinceRepository = $provinceRepository;
        $this->districtRepository = $districtRepository;
        $this->locationService = $locationService;
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

        return successResponse('Get province successfully.', $response);
    }

    public function getLocationByAddress(Request $request)
    {
        $addressData = $request->addressData;

        if (empty($addressData)) {
            return errorResponse('Get location failed.');
        }

        $response = $this->locationService->getLocationByAddress($addressData['address']);

        return successResponse('Get location successfully.', $response);
    }
}
