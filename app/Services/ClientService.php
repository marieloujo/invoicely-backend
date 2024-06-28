<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use Core\Services\AbstractCrudService;
use App\Services\Interfaces\ClientServiceInterface;

class ClientService extends AbstractCrudService implements ClientServiceInterface
{

    /**
     * ClientService constructor.
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        parent::__construct($clientRepository);
    }

}
