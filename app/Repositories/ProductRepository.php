<?php

namespace App\Repositories;
use Prettus\Repository\Contracts\RepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ProductRepository extends RepositoryInterface
{
    public function getAll();

    public function getMonthYear($monthno, $year);
}
