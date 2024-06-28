<?php

namespace App\Services;

use App\Repositories\ServiceRepository;
use App\Services\Interfaces\ServiceServiceInterface;

class ServiceService extends PriceableService implements ServiceServiceInterface
{

    /**
     * ServiceService constructor.
     *
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(ServiceRepository $serviceRepository)
    {
        parent::__construct($serviceRepository);
    }

}
