<?php

namespace App\Repositories;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Prettus\Repository\Contracts\RepositoryInterface;


interface CompanyRepository extends RepositoryInterface
{
    public function getAll();

    public function getAllForCustomer($company_id);
}
