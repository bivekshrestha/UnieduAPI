<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Trait ImageUploadAble
 * @package App\Traits
 */
trait ImageUploadAble
{
    /**
     * @param UploadedFile $file
     * @param string $folder
     * @param integer $width
     * @param integer $height
     * @param null $filename
     * @return false|string
     */
    public function uploadImage(UploadedFile $file, $folder, $width, $height, $filename = null)
    {
        $name = !is_null($filename) ? $filename : md5(time());

        $image = Image::make($file)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });

        $image->save(public_path($folder) . $name . '.' . $file->getClientOriginalExtension());

        return $folder . $name . '.' . $file->getClientOriginalExtension();
    }

    /**
     * @param null $path
     */
    public function deleteImage($path = null)
    {
        File::delete($path);
    }
}
