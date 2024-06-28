<?php

namespace App\Repositories;

use App\Models\Supply;
use Core\Repository\BaseRepository;

class SupplyRepository extends BaseRepository
{

   /**
    * SupplyRepository constructor.
    *
    * @param Supply $supply
    */
    public function __construct(Supply $supply)
    {
        parent::__construct($supply);
    }

}
