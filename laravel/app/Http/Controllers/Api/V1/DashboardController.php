<?php



namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function changeStatus(Request $request)
    {
        $serviceInstance = getServiceInstance($request->modelName);

        $response = $serviceInstance->updateStatus();

        return handleResponse($response);
    }

    public function changeStatusMultiple(Request $request)
    {
        $serviceInstance = getServiceInstance($request->modelName);

        $response = $serviceInstance->updateStatusMultiple();

        return handleResponse($response);
    }

    public function deleteMultiple(Request $request)
    {
        $serviceInstance = getServiceInstance($request->modelName);

        $response = $serviceInstance->deleteMultiple();

        return handleResponse($response);
    }

    public function getDataByModel(Request $request)
    {
        $serviceInstance = getServiceInstance($request->model);
        $response = $serviceInstance->paginate();

        return successResponse('', $response);
    }

    public function archiveMultiple(Request $request)
    {
        $serviceInstance = getServiceInstance($request->modelName);
        $response = $serviceInstance->handleArchiveMultiple();

        return handleResponse($response);
    }
}
