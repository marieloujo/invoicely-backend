<?php

namespace App\Services\Interfaces;

use App\Models\Facture;
use Core\Services\AbstractCrudServiceInterface;
use Illuminate\Http\JsonResponse;

/**FactureServiceInterface
* @package App\Services\Interfaces
*/
interface FactureServiceInterface extends AbstractCrudServiceInterface
{
    /**
     * @param Facture $facture
     * @return JsonResponse
     */
    public function markAsPaid(Facture $facture) : JsonResponse;
}
