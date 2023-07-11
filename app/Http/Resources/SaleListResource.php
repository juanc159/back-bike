<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleListResource extends JsonResource
{ 
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id, 
            "inventory_id" => $this->inventory_id,
            "inventory_reference" => $this->inventory?->reference,
            "inventory_purchaseValue" => $this->inventory?->purchaseValue,
            "inventory_saleValue" => $this->inventory?->saleValue,
            "description" => $this->description,
            "price_vehicle" => $this->price_vehicle,
            "total" => $this->total,
            "utilities" => $this->utilities,
        ];
    }
}
