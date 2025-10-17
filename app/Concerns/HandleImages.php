<?php

namespace App\Concerns;

use App\Jobs\ProcessUploadContactAvatar;
use Illuminate\Support\Facades\Storage;

trait HandleImages
{
    public function generateAvatarImages($avatar): string
    {
        $unique_id = uniqid();

        $new_original_file_name = 'contact_' . $unique_id . '.' . config('avatars.jpg_image_type');

        $full_path_to_original = Storage::disk('public')->putFileAs(
            config('avatars.original_path'),
            $avatar,
            $new_original_file_name
        );

        if ($full_path_to_original) {
            $avatar = $new_original_file_name;
            ProcessUploadContactAvatar::dispatch($new_original_file_name);
        } else {
            $avatar = '';
        }

        return $avatar;
    }
}
