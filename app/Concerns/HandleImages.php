<?php

namespace App\Concerns;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

trait HandleImages
{
    public function resize300($avatar): string
    {
        $image = Image::read($avatar)
            ->resize(300, 300)
            ->toJpeg(80);

        $file_name = 'contact_' . uniqid() . '_300x300.jpg';
        $path = "contacts/$file_name";

        Storage::disk('public')->put($path, $image->toString());

        return $path;
    }
}
