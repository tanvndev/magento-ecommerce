<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class BaseService
 */
class BaseService implements BaseServiceInterface
{
    public function __construct() {}

    protected function createSEO(array $payload, string $title = 'name', string $description = 'description'): array
    {
        $payload['meta_title'] = $payload['meta_title'] ?? $payload[$title];
        $payload['meta_description'] = $payload['meta_description'] ?? $payload[$description];
        $payload['meta_title'] = truncate($payload['meta_title']);
        $payload['meta_description'] = truncate($payload['meta_description'], 160);

        return $payload;
    }
    protected function convertToCode(string $str): string
    {
        $newStr = Str::slug($str);
        $newStr = strtoupper(str_replace('-', '', $newStr));
        $newStr .= rand(0, 1000);

        return $newStr;
    }

    public function updateStatus()
    {
        return $this->executeInTransaction(function () {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';

            $payload[request('field')] = request('value');
            $this->{$repositoryName}->update(request('modelId'), $payload);

            return successResponse('Cập nhập trạng thái thành công.');
        }, 'Cập nhập trạng thái thất bại.');
    }

    public function updateStatusMultiple()
    {
        return $this->executeInTransaction(function () {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';

            $payload[request('field')] = request('value');
            $this->{$repositoryName}->updateByWhereIn('id', request('modelIds'), $payload);

            return successResponse('Cập nhập trạng thái thành công.');
        }, 'Cập nhập trạng thái thất bại.');
    }

    public function deleteMultiple()
    {
        return $this->executeInTransaction(function () {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';
            $this->{$repositoryName}->deleteByWhereIn('id', request('modelIds'));

            return successResponse('Xoá thành công.');
        }, 'Xóa thất bại.');
    }

    protected function executeInTransaction($callback, string $messageError = '')
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            // getError($e);

            Log::error('>>Transaction failed<<', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                // 'trace' => $e->getTraceAsString(),
            ]);
            DB::rollBack();

            return errorResponse($messageError);
        }
    }
}
