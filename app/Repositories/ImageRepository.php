<?php

namespace App\Repositories;

/**
 * Interface ImageRepository.
 */
interface ImageRepository
{
    public function uploadImage($file,$folder_name);

    public function generateThumbnail($file_name,$folder_name);
}
