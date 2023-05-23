<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type_name' => $this->typeProduct?->name,
            'factoryReference' => $this->factoryReference,
            'state' => $this->state,
            'taxCharge_name' => $this->taxCharge?->name,
            'description' => $this->description,
            'price' => $this->price
        ];
    }
}
