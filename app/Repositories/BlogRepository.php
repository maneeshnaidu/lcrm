<?php
namespace App\Repositories;
use Prettus\Repository\Contracts\RepositoryInterface;

interface BlogRepository extends RepositoryInterface
{
    public function getAll();
}
