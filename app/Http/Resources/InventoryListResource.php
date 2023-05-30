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
            "reference" => $this->reference,
            "vehicleType" => $this->vehicleType,
            "brand" => $this->brand,
            "model" => $this->model,
            "color" => $this->color,
            "plate" => $this->plate,
            "registrationSite" => $this->registrationSite,
            "purchaseValue" => $this->purchaseValue,
            "saleValue" => $this->saleValue,
            "state" => $this->state,
            "days" => $this->days,
        ];
    }
}
