<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeVehicleListResource extends JsonResource
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
            "date_init" => $this->date_init,
            "company_id" => $this->company_id,
            "mecanic_id" => $this->mecanic_id,
            "type_vehicle" => $this->type_vehicle,
            "brand" => $this->brand,
            "pay_labor" => $this->pay_labor,
            "plate" => $this->plate,
            "value_labor" => $this->value_labor,
            "value_parts" => $this->value_parts,
            "total_costs" => $this->total_costs,
            "paid_labor" => $this->paid_labor,
            "date_pay_labor" => $this->date_pay_labor,
            "utilites" => $this->utilites,
        ];
    }
}
