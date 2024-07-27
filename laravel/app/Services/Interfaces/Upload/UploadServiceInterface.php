<?php

namespace App\Services\Interfaces\Upload;

interface UploadServiceInterface
{
    public function paginate();
    public function create();
    public function destroy($id);
}
