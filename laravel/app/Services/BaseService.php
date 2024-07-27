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


    protected  function convertToCode($str)
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
        DB::beginTransaction();
        try {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';
            $payload[request('field')] = request('value');
            $this->{$repositoryName}->update(request('modelId'), $payload);
            DB::commit();
            return [
                'status' => 'success',
                'messages' => 'Cập nhập trạng thái thành công.',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Cập nhập trạng thái thất bại.',
                'data' => null
            ];
        }
    }

    public function updateStatusMultiple()
    {
        DB::beginTransaction();
        try {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';

            $payload[request('field')] = request('value');
            $this->{$repositoryName}->updateByWhereIn('id', request('modelIds'), $payload);

            DB::commit();
            return [
                'status' => 'success',
                'messages' => 'Cập nhập trạng thái thành công.',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Cập nhập trạng thái thất bại.',
                'data' => null
            ];
        }
    }

    public function deleteMultiple()
    {

        DB::beginTransaction();
        try {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';
            $this->{$repositoryName}->deleteByWhereIn('id', request('modelIds'));

            DB::commit();
            return [
                'status' => 'success',
                'messages' => 'Xoá thành công.',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Xoá thất bại.',
                'data' => null
            ];
        }
    }
}
