<?php

namespace App\Repositories;

use App\Models\Facture;
use Core\Repository\BaseRepository;

class FactureRepository extends BaseRepository
{

   /**
    * FactureRepository constructor.
    *
    * @param Facture $facture
    */
    public function __construct(Facture $facture)
    {
        parent::__construct($facture);
    }

}
