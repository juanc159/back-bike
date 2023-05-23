<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThirdListResource extends JsonResource
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
            "name" => $this->name,
            "last_name" => $this->last_name,
            "trade_name" => $this->trade_name,
            "identifications" => $this->identifications,
            "branch_code" => $this->branch_code,
            "city" => $this->city,
            "state" => $this->state,
            "address" => $this->address,
            "contact_name" => $this->contact_name,
            "contact_last_name" => $this->contact_last_name,
            "email_fac" => $this->email_fac,
            "indicative" => $this->indicative,
            "phone_fac" => $this->phone_fac,
            "postal_code" => $this->postal_code,
            "observations" => $this->observations,
            "basic_data_types_id" => $this->basic_data_types_id,
            "type_identifications_id" => $this->type_identifications_id,
            "type_of_thirds_id" => $this->type_of_thirds_id,
            "type_regime_ivas_id" => $this->type_regime_ivas_id,
            "seller_id" => $this->seller_id,
            "debt_seller_id" => $this->debt_seller_id,
            "company_id" => $this->company_id,
            'nametypeIdentificaction' => $this->typeIdentificaction?->name,
            'nametypeRegimenIva' => $this->TypeRegimenIva?->name,
            /* "arrayPhone" => $this->arrayPhone,
            "arrayContact" => $this->arrayContact,
            "arrayFiscalResponsability" => $this->arrayFiscalResponsability, */
        ];
    }
}
