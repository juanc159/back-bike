<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryListResource extends JsonResource
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
            "item" => $this->item,
            "reference" => $this->reference,
            "brand" => $this->brand,
            "model" => $this->model,
            "color" => $this->color,
            "plate" => $this->plate,
            "registrationSite" => $this->registrationSite,
            "value" => $this->value
        ];
    }
}
