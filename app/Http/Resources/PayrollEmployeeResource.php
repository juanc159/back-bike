<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayrollEmployeeResource extends JsonResource
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
            'full_name' => $this->name.' '.$this->last_name,
            'document_number' => $this->document_number,
            'salary' => $this->workingInformation?->salary ?? 0,
            'extra_hours' => 0,
            'bonuses' => 0,
            'commissions' => 0,
            'other_discounts' => 0,
            'risk_class_value' => $this->workingInformation?->risk_class?->value ?? 0,
        ];
    }
}
