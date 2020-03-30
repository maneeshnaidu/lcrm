<?php

namespace App\Repositories;

use App\Models\Customer;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class CustomerRepositoryEloquent extends BaseRepository implements CustomerRepository
{
    private $userRepository;

    private $organizationRepository;
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Customer::class;
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

        $this->organizationRepository = new OrganizationRepositoryEloquent(app());
    }

    public function getAll()
    {
        $this->generateParams();
        $org = $this->userRepository->getOrganization()->load('customers.user','customers.company');
        return $org->customers;
    }

    public function getUser($customer)
    {
        $this->generateParams();
        $customers = $this->with('user')->find($customer);
        return $customers;
    }
}
