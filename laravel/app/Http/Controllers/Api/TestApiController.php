<?php

namespace App\Http\Controllers\Api;

use App\Classes\Upload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TestApiController extends Controller
{
    public function index()
    {
        Session::put('key', ['a', 'b', 'c']);

        dd(Session::get('key'));
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');

        Upload::uploadImage($file);
    }
}
