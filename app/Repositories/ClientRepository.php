<?php

namespace App\Repositories;

use App\Models\Client;
use Core\Repository\BaseRepository;

class ClientRepository extends BaseRepository
{

   /**
    * ClientRepository constructor.
    *
    * @param Client $client
    */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

}
