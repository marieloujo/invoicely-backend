<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $price = $this->price;
        $priceable = $price->priceable;

        return [
            'quantity' => $this->quantity,
            'total_amount_excl' => $this->total_amount_excl,
            'total_amount_incl' => $this->total_amount_incl,
            'priceable' => [
                'id' => $priceable->id,
                'designation' => $priceable->designation,
                "unit_price_excl" => $price->unit_price_excl,
                "unit_price_incl" => $price->unit_price_incl,
            ],
        ];
    }
}
