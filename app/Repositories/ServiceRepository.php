<?php

namespace App\Repositories;

use App\Models\Service;
use Core\Repository\BaseRepository;

class ServiceRepository extends BaseRepository
{

   /**
    * ServiceRepository constructor.
    *
    * @param Service $service
    */
    public function __construct(Service $service)
    {
        parent::__construct($service);
    }

}
