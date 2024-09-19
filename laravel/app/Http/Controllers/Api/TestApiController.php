<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TestApiController extends Controller
{
    public function index()
    {
        Session::put('key', ['a', 'b', 'c']);

        dd(Session::get('key'));
    }
}
