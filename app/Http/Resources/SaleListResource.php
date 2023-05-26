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
            "inventory_value" => $this->inventory?->value,
            "description" => $this->description,
            "total" => $this->total,
            "utilities" => $this->utilities,
        ];
    }
}
