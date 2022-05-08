<?php

namespace App\Helpers;

class UploadHelper
{
    public static function uploadImage($file, string $path)
    {
        $generated_img_name = bin2hex(openssl_random_pseudo_bytes(10)) . '.' . $file->getClientOriginalExtension();

        $file->storeAs($path, $generated_img_name);
        return $generated_img_name;
    }
}
