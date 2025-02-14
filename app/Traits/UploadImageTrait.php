<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait UploadImageTrait
{
    /**
     * Handle image upload
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $folder
     * @return string $filename
     */
    public function uploadImage($image, $folder = 'topicImages')
    {
        // Generate unique filename
        $filename = time() . '.' . $image->getClientOriginalExtension();

        // Save the image to the specified folder in public
        $image->move(public_path($folder), $filename);

        return $filename;
    }

    /**
     * Delete an existing image
     *
     * @param string $filename
     * @param string $folder
     * @return bool
     */
    public function deleteImage($filename, $folder = 'topicImages')
    {
        $path = public_path($folder . '/' . $filename);

        if (File::exists($path)) {
            return File::delete($path);
        }

        return false;
    }
}
