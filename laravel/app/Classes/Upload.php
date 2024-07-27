<?php

namespace App\Classes;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;


class Upload
{
    public static function uploadImage($image)
    {
        // dd($image);
        $imageSrc = env('IMAGE_SOURCE_PATH');
        $fileList = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif', 'tiff', 'heic', 'raw'];
        try {
            $extension = strtolower($image->getClientOriginalExtension());
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension;
            if ($image != null && in_array($extension, $fileList)) {

                // Kiểm tra kích thước của ảnh
                if ($image->getSize() > 5000000) {
                    return [
                        'status' => 'error',
                        'message' => 'Dung lượng tệp ---> ' . $originalName . ' <--- không được vượt quá 5MB.'
                    ];
                }
                // dd($image);

                $uuid = uniqid();
                $path = $imageSrc . date('Y') . '/' . date('m');
                $filename = Str::slug($originalName) . '_' . $uuid . '.webp'; // Change the extension to .webp

                // Create the directory if it doesn't exist
                if (!Storage::exists($path)) {
                    Storage::makeDirectory($path);
                }
                // dd($path . '/' . $filename);

                // Optimize and convert the image to .webp
                $img = Image::make($image)
                    ->encode('webp', 90); // Encode to .webp with 80% quality


                $temporaryDirectory = storage_path('app/temp/');

                if (!File::exists($temporaryDirectory)) {
                    // Nếu chưa tồn tại, tạo thư mục
                    File::makeDirectory($temporaryDirectory, $mode = 0755, true, true);
                }

                // Save the optimized image temporarily
                $temporaryPath =  $temporaryDirectory . $filename;
                $img->save($temporaryPath);

                // Optimize the image further using spatie/image-optimizer
                $optimizerChain = OptimizerChainFactory::create();
                $optimizerChain->optimize($temporaryPath);

                // Move the optimized image to the final destination
                $storedPath = $path . '/' . $filename;
                Storage::put($storedPath, file_get_contents($temporaryPath));

                // Remove temporary file
                unlink($temporaryPath);
                return [
                    'status' => 'success',
                    'message' => 'Tải lên ảnh thành công.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Định dạng tệp ---> ' . $originalName . ' <--- không hợp lệ. Chỉ chấp nhận các định dạng: JPG, JPEG, PNG, WEBP, SVG, GIF, TIFF, HEIC, RAW.'
                ];
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            return [
                'status' => 'error',
                'message' => 'Có lỗi từ tệp ---> ' . $originalName . ' <--- vui lòng thử tải lại.'
            ];
        }
    }
}
