<?php

namespace App\Repositories;

use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class ImageRepositoryEloquent.
 */
class ImageRepositoryEloquent implements ImageRepository
{
    public function uploadImage($file, $folder_name)
    {
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $picture = str_random(10).'.'.$extension;

        $image = Image::make($file)->orientate();
        $originalPath = public_path().'/uploads/'.$folder_name.'/';
        $image->save($originalPath.$picture);
        return $picture;
    }

    public function generateThumbnail($file_name, $folder_name)
    {
        $originalPath = public_path().'/uploads/'.$folder_name.'/';
        $image = Image::make($originalPath.$file_name);
        $image->resize(null,150, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($originalPath.'thumb_'.$file_name);
    }
}
