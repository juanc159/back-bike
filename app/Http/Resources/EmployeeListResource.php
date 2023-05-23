<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeListResource extends JsonResource
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
            'last_name' => $this->last_name,
            'type_identifications_id' => $this->type_identifications_id,
            'type_identifications_name' => $this->typeIdentification?->name,
            'document_number' => $this->document_number,
            'email' => $this->email,
        ];
    }
}
