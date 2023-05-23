<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource; 

class TypesQuoteListResource extends JsonResource
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
            'voucherCode' => $this->voucherCode, 
            'voucherName' => $this->voucherName,
            'inUse' => $this->inUse == 1 ? 'En Uso' : 'No esta en uso',
        ];
    }
}
