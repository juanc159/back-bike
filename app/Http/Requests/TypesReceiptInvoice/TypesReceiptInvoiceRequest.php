<?php

namespace App\Http\Requests\TypesReceiptInvoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TypesReceiptInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return  [
            'voucherCode' => 'required|max:3',
            'voucherName' => 'required|min:6|max:50',
            'resolutionNumberDian' => 'required|max:100',
            'effectiveDate' => 'required',
            'validityInMonths_id' => 'required',
            'prefix' => 'required|max:4',
            'initialNumbering' => 'required',
            'finalNumbering' => 'required|max:10',
            'nextInvoiceNumber' => 'required|max:10',
            'discountTypePerItem_id' => 'required',
            'LedgerAccountsDiscount_id' => 'required',
            'LedgerAccountsGift_id' => 'required',
            'format_id' => 'required',
            'titleForDisplay' => 'required|max:50',
            'address' => 'required|max:100',
            'observations' => 'required',
            'affair' => 'required|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'voucherCode.required' => 'El campo es obligatorio',
            'voucherCode.max' => 'El campo debe contener maximo 3 caracteres',

            'voucherName.required' => 'El campo es obligatorio',
            'voucherName.min' => 'El campo debe contener minimo 6 caracteres',
            'voucherName.max' => 'El campo debe contener maximo 50 caracteres',

            'resolutionNumberDian.required' => 'El campo es obligatorio',
            'resolutionNumberDian.max' => 'El campo debe contener maximo 100 caracteres',

            'effectiveDate.required' => 'El campo es obligatorio',
            'validityInMonths_id.required' => 'El campo es obligatorio',

            'prefix.required' => 'El campo es obligatorio',
            'prefix.max' => 'El campo debe contener maximo 4 caracteres',

            'initialNumbering.required' => 'El campo es obligatorio',

            'finalNumbering.required' => 'El campo es obligatorio',
            'finalNumbering.max' => 'El campo debe contener maximo 10 caracteres',

            'nextInvoiceNumber.required' => 'El campo es obligatorio',
            'nextInvoiceNumber.max' => 'El campo debe contener maximo 10 caracteres',

            'discountTypePerItem_id.required' => 'El campo es obligatorio',
            'LedgerAccountsDiscount_id.required' => 'El campo es obligatorio',
            'LedgerAccountsGift_id.required' => 'El campo es obligatorio',
            'format_id.required' => 'El campo es obligatorio',

            'titleForDisplay.required' => 'El campo es obligatorio',
            'titleForDisplay.max' => 'El campo debe contener maximo 50 caracteres',
            
            'address.required' => 'El campo es obligatorio',
            'address.max' => 'El campo debe contener maximo 100 caracteres',

            'observations.required' => 'El campo es obligatorio',
            
            'affair.required' => 'El campo es obligatorio',
            'affair.max' => 'El campo debe contener maximo 100 caracteres',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'status' => 422,
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ]));
    }
}
