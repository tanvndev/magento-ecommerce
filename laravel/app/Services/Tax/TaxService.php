<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Tax;

use App\Repositories\Interfaces\Tax\TaxRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Tax\TaxServiceInterface;

class TaxService extends BaseService implements TaxServiceInterface
{
    protected $taxRepository;

    public function __construct(
        TaxRepositoryInterface $taxRepository,
    ) {
        $this->taxRepository = $taxRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
            'searchFields' => ['name', 'code', 'rate'],
        ];
        $select = ['id', 'name', 'publish', 'code', 'rate'];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->taxRepository->pagination($select, $condition, $pageSize)
            : $this->taxRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $this->taxRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->taxRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->taxRepository->delete($id);

            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
