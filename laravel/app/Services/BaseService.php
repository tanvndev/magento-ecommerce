<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    public function __construct()
    {
    }

    protected function convertToCode($str)
    {
        $newStr = Str::slug($str);
        $newStr = strtoupper(str_replace('-', '', $newStr));
        $newStr .= rand(0, 1000);
        return $newStr;
    }


    protected function formatJson($payload, $inputName)
    {
        // Lấy ra payload từ form
        if (isset($payload[$inputName]) && !empty($payload[$inputName])) {
            $payload[$inputName] = json_encode($payload[$inputName]);
        }
        return $payload;
    }

    public function updateStatus()
    {
        $this->executeInTransaction(function () {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';

            $payload[request('field')] = request('value');
            $this->{$repositoryName}->update(request('modelId'), $payload);

            return successResponse('Cập nhập trạng thái thành công.');
        }, 'Cập nhập trạng thái thất bại.');
    }

    public function updateStatusMultiple()
    {
        $this->executeInTransaction(function () {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';

            $payload[request('field')] = request('value');
            $this->{$repositoryName}->updateByWhereIn('id', request('modelIds'), $payload);

            return successResponse('Cập nhập trạng thái thành công.');
        }, 'Cập nhập trạng thái thất bại.');
    }

    public function deleteMultiple()
    {
        $this->executeInTransaction(function () {
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
            dd($e->getMessage() . $e->getLine() . $e->getFile());
            DB::rollBack();
            return errorResponse($messageError);
        }
    }
}
