<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Location;

use App\Repositories\Interfaces\Location\DistrictRepositoryInterface;
use App\Repositories\Interfaces\Location\ProvinceRepositoryInterface;
use App\Repositories\Interfaces\Location\WardRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Location\LocationServiceInterface;
use Illuminate\Http\Client\Request;

class LocationService extends BaseService implements LocationServiceInterface
{
    protected $provinceRepository;

    protected $districtRepository;

    protected $wardRepository;

    public function __construct(
        ProvinceRepositoryInterface $provinceRepository,
        DistrictRepositoryInterface $districtRepository,
        WardRepositoryInterface $wardRepository
    ) {
        $this->provinceRepository = $provinceRepository;
        $this->districtRepository = $districtRepository;
        $this->wardRepository = $wardRepository;
    }

    public function getLocationByAddress($address)
    {

        $wardName = $address['quarter'] ?? $address['suburb'];
        $districtName = $address['city_district'] ?? $address['suburb'];

        $wardConditions = [
            'full_name' => ['LIKE', '%' . $wardName . '%'],
        ];

        $withRelations = [
            'districts' => [
                ['full_name', 'LIKE', '%' . $districtName . '%'],
            ],
        ];

        $ward = $this->wardRepository->findByWhere(
            $wardConditions,
            ['*'],
            ['districts.provinces'],
            false,
            ['code' => 'ASC'],
            [],
            $withRelations
        );

        if (empty($ward)) {
            return [];
        }

        return $this->formatLocationData($ward);
    }

    private function formatLocationData($data)
    {
        $districts = $this->provinceRepository->findByWhere(
            ['code' => $data['districts']['provinces']['code']],
            ['code', 'name', 'full_name'],
            ['districts'],
        );

        $wards = $this->districtRepository->findByWhere(
            ['code' => $data['districts']['code']],
            ['code', 'name', 'full_name'],
            ['wards'],
        );

        return [
            'ward' => [
                'target'    => 'wards',
                'code'      => $data['code'],
                'name'      => $data['name'],
                'full_name' => $data['full_name'],
                'data'      => $wards?->wards ?? [],
            ],
            'district' => [
                'target'    => 'districts',
                'code'      => $data['districts']['code'],
                'name'      => $data['districts']['name'],
                'full_name' => $data['districts']['full_name'],
                'data'      => $districts?->districts ?? [],
            ],
            'province' => [
                'target'    => 'provinces',
                'code'      => $data['districts']['provinces']['code'],
                'name'      => $data['districts']['provinces']['name'],
                'full_name' => $data['districts']['provinces']['full_name'],
            ],
        ];
    }

    public function calculateDistance(Request $request)
    {
        $latFrom = $request->input('latFrom', 21.0148521);
        $lonFrom = $request->input('lonFrom', 105.8116394);
        $latTo = $request->input('latTo', 10.7375481);
        $lonTo = $request->input('lonTo', 106.7302238);

        $distance = haversineGreatCircleDistance($latFrom, $lonFrom, $latTo, $lonTo);

        return response()->json(['distance_km' => $distance]);
    }
}
