<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Str;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    private $userRepository;
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function generateParams(){


        $this->userRepository = new UserRepositoryEloquent(app());
    }

    public function getAll()
    {
        $this->generateParams();
        $products = $this->userRepository->getOrganization()->products()->get();
        return $products;
    }

    public function getMonthYear($monthno, $year)
    {
        $products = $this->userRepository->getOrganization()->products()->whereYear('created_at', $year)->whereMonth('created_at', $monthno)->get();

        return $products;
    }
}
