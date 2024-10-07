<?php

namespace App\Http\Controllers\Stringee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StringeeController extends Controller
{
    public function answer(Request $request)
    {
        \Log::info($request->all());
        \Log::info(Cache::get('verification_code_' . '0332225690'));

        dd(Cache::get('verification_code_' . '0332225690'));
    }
}
