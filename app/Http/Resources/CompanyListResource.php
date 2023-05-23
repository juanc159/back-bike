<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyListResource extends JsonResource
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
            'email' => $this->email,
            'nit' => $this->nit,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'state' => $this->state,
            'identification_rep' => $this->identification_rep,
            'address_rep' => $this->address_rep,
            'email_rep' => $this->email_rep,
            'nameLegalRepresentative' => $this->nameLegalRepresentative,
            'phoneLegalRepresentative' => $this->phoneLegalRepresentative,
        ];
    }
}
