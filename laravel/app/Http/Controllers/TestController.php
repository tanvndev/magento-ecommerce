<?php

namespace App\Http\Controllers;

use App\Classes\Upload;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        Upload::uploadImage($file);
    }
}
