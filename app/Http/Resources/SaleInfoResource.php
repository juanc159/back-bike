<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleInfoResource extends JsonResource
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
            "company_id" => $this->company_id,
            "description" => $this->inventory?->reference,
            "inventory_id" => $this->inventory_id,
            "total" => $this->total,
            "utilities" => $this->utilities,
            "thirds" => $this->thirds->map(function($x){
                return [
                    "id"=> $x->id,
                    "name"=> $x->name,
                    "amount"=> $x->pivot->amount
                ];
            }),
        ];
    }
}
