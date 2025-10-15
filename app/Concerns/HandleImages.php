<?php

namespace App\Concerns;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

trait HandleImages
{
    public function generateAllSizedImages($avatar): string
    {
        $unique_id = uniqid();

        $path_db = 'contact_' . $unique_id . '.jpg';

        foreach (config('avatars.sizes') as $key => $size) {
            $base_file_name = 'contact_' . $unique_id . '.jpg';
            $file_name = substr_replace($base_file_name, "_$size", -4, 0);

            $image = Image::read($avatar)
                ->cover($key, $key)
                ->toJpeg(80);

            $path_storage = "contacts/$key/$file_name";
            Storage::disk('public')->put($path_storage, $image->toString());
        }

        return $path_db;
    }
}
