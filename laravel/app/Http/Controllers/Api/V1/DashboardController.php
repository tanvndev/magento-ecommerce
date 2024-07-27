<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function changeStatus(Request $request)
    {
        // Lấy ra service tương ứng
        $serviceInstance = getServiceInstance($request->modelName);

        // Cập nhập trạng thái
        $response = $serviceInstance->updateStatus();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    public function changeStatusMultiple(Request $request)
    {

        // Lấy ra service tương ứng
        $serviceInstance = getServiceInstance($request->modelName);
        // Cập nhập trạng thái
        $response = $serviceInstance->updateStatusMultiple();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    public function deleteMultiple(Request $request)
    {

        // Lấy ra service tương ứng
        $serviceInstance = getServiceInstance($request->modelName);
        // return response()->json($serviceInstance);
        // Xoa nhieu
        $response = $serviceInstance->deleteMultiple();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
