<?php

namespace App\Http\Controllers\Api\V1;

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

        return handleResponse($response);
    }

    public function changeStatusMultiple(Request $request)
    {

        // Lấy ra service tương ứng
        $serviceInstance = getServiceInstance($request->modelName);

        // Cập nhập trạng thái
        $response = $serviceInstance->updateStatusMultiple();

        return handleResponse($response);
    }

    public function deleteMultiple(Request $request)
    {
        // Lấy ra service tương ứng
        $serviceInstance = getServiceInstance($request->modelName);

        // Xoa nhieu
        $response = $serviceInstance->deleteMultiple();

        return handleResponse($response);
    }

    public function getDataByModel(Request $request)
    {
        $serviceInstance = getServiceInstance($request->model);
        $response = $serviceInstance->paginate();

        return successResponse('', $response);
    }
}
