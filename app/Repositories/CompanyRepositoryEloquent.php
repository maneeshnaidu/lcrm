<?php

namespace App\Repositories;

use App\Models\Company;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class CompanyRepositoryEloquent extends BaseRepository implements CompanyRepository
{
    private $userRepository;
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Company::class;
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
        $org = $this->userRepository->getOrganization()->load('companies.contactPerson','companies.country','companies.state','companies.city');
        return $org->companies;
    }

    public function getAllForCustomer($company_id)
    {
        $this->generateParams();
        $companies = $this->userRepository->getOrganization()->companies()->get();
        return $companies;
    }
}
