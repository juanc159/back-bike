<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WayToPayGeneralListResource extends JsonResource
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
            'company_id' => $this->company_id,
            'in_use' => $this->in_use,
            'code' => $this->code,
            'name' => $this->name,
            'related_to_id' => $this->relatedTo?->id,
            'related_to_name' => $this->relatedTo?->name,
            'ledger_account_auxiliary_id' => $this->ledgerAccountAuxiliary?->id,
            'ledger_account_auxiliary_code' => $this->ledgerAccountAuxiliary?->code,
            'ledger_account_auxiliary_name' => $this->ledgerAccountAuxiliary?->name,
            'payment_method_id' => $this->paymentMethod?->id,
            'payment_method_code' => $this->paymentMethod?->code,
            'payment_method_name' => $this->paymentMethod?->name,
        ];
    }
}
