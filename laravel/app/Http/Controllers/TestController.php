<?php

namespace App\Http\Controllers;

use App\Classes\Upload;
use App\Services\Interfaces\Apriori\AprioriServiceInterface;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function __construct(
        protected AprioriServiceInterface $aprioriService
    ) {}
    public function getOrder(Request $request)
    {
        // $orders = $this->aprioriService->exportOrdersToCsv();
        $this->aprioriService->getAprioriResultsFromRedis();
    }
}
