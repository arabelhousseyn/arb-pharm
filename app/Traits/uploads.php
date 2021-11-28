<?php

namespace App\Traits;

trait uploads{

    public function ImageUpload($base64,$folder,$extension)
    {
        $path = '';
        $folderPath = env('MAIN_PATH') . $folder . '/';
        $image_base64 = base64_decode($base64);
        $path = uniqid() . $extension;
        $file = $folderPath . $path;
        file_put_contents($file, $image_base64);
        return $path;
    }
}
