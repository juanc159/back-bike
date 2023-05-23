<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceListResource extends JsonResource
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
            "typesReceiptInvoice_id" => $this->typesReceiptInvoice_id,
            "customer_id" => $this->customer_id,
            "seller_id" => $this->seller_id,
            "currency_id" => $this->currency_id,
            "company_id" => $this->company_id,
            "date_elaboration" => $this->date_elaboration,
            "number" => $this->number,
            "gross_total" => $this->gross_total,
            "discount" => $this->discount,
            "subtotal" => $this->subtotal,
            "total_form_payment" => $this->total_form_payment,
            "net_total" => $this->net_total,

            'type_name' => $this->typesReceiptInvoice?->voucherName,
            'third_name' => $this->third?->name,
            'user_name' => $this->user?->name,
            'currency_name' => $this->currency?->name,
            'company_name' => $this->company?->name,

        ];
    }
}
