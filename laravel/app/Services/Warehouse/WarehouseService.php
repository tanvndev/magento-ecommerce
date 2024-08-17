<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Warehouse;

use App\Repositories\Interfaces\Warehouse\AisleRepositoryInterface;
use App\Repositories\Interfaces\Warehouse\CompartmentRepositoryInterface;
use App\Repositories\Interfaces\Warehouse\RackRepositoryInterface;
use App\Repositories\Interfaces\Warehouse\ShelfRepositoryInterface;
use App\Repositories\Interfaces\Warehouse\WarehouseRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Warehouse\WarehouseServiceInterface;

class WarehouseService extends BaseService implements WarehouseServiceInterface
{
    protected $warehouseRepository;

    protected $aisleRepository;

    protected $rackRepository;

    protected $shelfRepository;

    protected $compartmentRepository;

    private $warehouse;

    private $maxWeightCapacity = 100;

    public function __construct(
        WarehouseRepositoryInterface $warehouseRepository,
        AisleRepositoryInterface $aisleRepository,
        RackRepositoryInterface $rackRepository,
        ShelfRepositoryInterface $shelfRepository,
        CompartmentRepositoryInterface $compartmentRepository
    ) {
        $this->warehouseRepository = $warehouseRepository;
        $this->aisleRepository = $aisleRepository;
        $this->rackRepository = $rackRepository;
        $this->shelfRepository = $shelfRepository;
        $this->compartmentRepository = $compartmentRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
            'searchFields' => ['name', 'code', 'phone', 'supervisor_name'],
        ];
        $select = [
            'id', 'name', 'code', 'phone', 'address', 'description', 'total_capacity',
            'used_capacity', 'supervisor_name', 'publish', 'aisles_number',
            'racks_number', 'shelves_number', 'compartments_number',
        ];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->warehouseRepository->pagination($select, $condition, $pageSize)
            : $this->warehouseRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->perparePayload();
            $warehouse = $this->warehouseRepository->create($payload);

            $this->createWarehouse($warehouse, $payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->perparePayload();
            $warehouse = $this->warehouseRepository->save($id, $payload);

            $this->createWarehouse($warehouse, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }

    private function createWarehouse($warehouse, array $payload)
    {
        if (! $warehouse) {
            throw new \Exception('Warehouse not created.');
        }

        $this->warehouse = collect([
            'code' => $warehouse->code,
            'name' => $warehouse->name,
        ]);

        $this->createWarehouseStructure($warehouse, $payload);
    }

    private function perparePayload(): array
    {
        $payload = request()->except('_token', '_method');
        if (isset($payload['warehouse_configurations']) && ! empty($payload['warehouse_configurations'])) {
            $configurations = explode('-', $payload['warehouse_configurations']);
            $payload['aisles_number'] = (int) $configurations[0];
            $payload['racks_number'] = (int) $configurations[1];
            $payload['shelves_number'] = (int) $configurations[2];
            $payload['compartments_number'] = (int) $configurations[3];
        }
        $payload['total_capacity'] = $payload['aisles_number'] * $payload['racks_number'] * $payload['shelves_number'] * $payload['compartments_number'] * $this->maxWeightCapacity;

        return $payload;
    }

    private function createWarehouseStructure($warehouse, array $payload)
    {
        $aisleNumbers = $payload['aisles_number'];
        $rackNumbers = $payload['racks_number'];
        $shelfNumbers = $payload['shelves_number'];
        $compartmentNumbers = $payload['compartments_number'];

        for ($aisleNumber = 1; $aisleNumber <= $aisleNumbers; $aisleNumber++) {
            $aisle = $this->createAisle($warehouse->id, $aisleNumber);

            for ($rackNumber = 1; $rackNumber <= $rackNumbers; $rackNumber++) {
                $rack = $this->createRack($aisle->id, $aisle->code, $rackNumber);

                for ($shelfNumber = 1; $shelfNumber <= $shelfNumbers; $shelfNumber++) {
                    $shelf = $this->createShelf($rack->id, $aisle->code, $rack->code, $shelfNumber);

                    $this->createCompartments($shelf, $compartmentNumbers);
                }
            }
        }
    }

    private function createAisle($warehouseId, $number)
    {
        $warehouseName = $this->warehouse->get('name');
        $warehouseCode = $this->warehouse->get('code');
        $aisleCode = sprintf('%s-A%02d', $warehouseCode, $number);

        return $this->aisleRepository->firstOrCreate(
            [
                'code' => $aisleCode,
            ],
            [
                'warehouse_id' => $warehouseId,
                'name' => "Dãy {$number} tại <{$warehouseName}>",
                'code' => $aisleCode,
                'description' => "Đây là dãy {$number}",
            ]
        );
    }

    private function createRack($aisleId, $aisleCode, $rackNumber)
    {
        $rackCode = sprintf('%s-R%02d', $aisleCode, $rackNumber);

        return $this->rackRepository->firstOrCreate(
            [
                'code' => $rackCode,
            ],
            [
                'aisle_id' => $aisleId,
                'name' => "Kệ {$rackNumber}",
                'code' => $rackCode,
                'description' => "Đây là kệ {$rackNumber} của dãy {$aisleCode}",
            ]
        );
    }

    private function createShelf($rackId, $aisleCode, $rackCode, $shelfNumber)
    {
        $shelfCode = sprintf('%s-S%02d', $rackCode, $shelfNumber);

        return $this->shelfRepository->firstOrCreate(
            [
                'code' => $shelfCode,
            ],
            [
                'rack_id' => $rackId,
                'name' => "Tầng {$shelfNumber}",
                'code' => $shelfCode,
                'description' => "Đây là tầng {$shelfNumber} trong kệ {$rackCode} của dãy {$aisleCode}",
            ]
        );
    }

    private function createCompartments($shelf, $compartmentNumbers)
    {
        $shelfId = $shelf->id;
        $shelfCode = $shelf->code;

        for ($compartmentNumber = 1; $compartmentNumber <= $compartmentNumbers; $compartmentNumber++) {
            $compartmentCode = sprintf('%s-C%02d', $shelfCode, $compartmentNumber);

            $this->compartmentRepository->firstOrCreate(
                [
                    'code' => $compartmentCode,
                ],
                [
                    'shelf_id' => $shelfId,
                    'name' => "Khoang {$compartmentNumber}",
                    'code' => $compartmentCode,
                    'description' => $this->generateCompartmentDescription($compartmentCode),
                    'max_weight_capacity' => $this->maxWeightCapacity,
                ]
            );
        }
    }

    private function generateCompartmentDescription(string $compartmentCode): string
    {
        $parts = explode('-', $compartmentCode);
        $aisleCode = substr($parts[1], 1); // Remove 'A' prefix
        $rackCode = substr($parts[2], 1); // Remove 'R' prefix
        $shelfNumber = substr($parts[3], 1); // Remove 'S' prefix
        $compartmentNumber = substr($parts[4], 1); // Remove 'C' prefix

        $warehouseName = $this->warehouse->get('name');
        $warehouseCode = $this->warehouse->get('code');

        $result = "Đây là khoang {$compartmentNumber} của kệ {$rackCode} trên tầng {$shelfNumber} thuộc dãy {$aisleCode} tại <{$warehouseCode} - {$warehouseName}>";

        return $result;
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->warehouseRepository->delete($id);

            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
