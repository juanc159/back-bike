<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TypesReceiptInvoiceListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentDate = Carbon::now();
        $isValid = Carbon::parse($this->endDateValidity)->greaterThanOrEqualTo($currentDate);
        if($isValid) $valid = 'Vigente';
        else $valid = 'No Vigente';

        return [
            'id' => $this->id, 
            'voucherCode' => $this->voucherCode, 
            'voucherName' => $this->voucherName, 
            'titleForDisplay' => $this->titleForDisplay, 
            'resolutionNumberDian' => $this->resolutionNumberDian, 
            'endDateValidity' => $valid, 
        ];
    }
}
