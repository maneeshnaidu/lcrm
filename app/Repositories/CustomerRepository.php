<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;


interface CustomerRepository extends RepositoryInterface
{
    public function getAll();

    public function getUser($customer);
}
