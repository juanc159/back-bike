<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Carbon;

class InvoiceRequest extends FormRequest
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
        $minDate = Carbon::now()->subDays(9)->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');
        return[
            'typesReceiptInvoice_id' => 'required',

            'number' => 'required|unique:invoices,number,'.$this->id.',id,company_id,'.$this->company_id.',typesReceiptInvoice_id,'.$this->typesReceiptInvoice_id,

            'customer_id' => 'required',
            'seller_id' => 'required',
            'date_elaboration' => 'required|date|after_or_equal:'.$minDate.'|before_or_equal:'.$now,
            'currency_id' => 'required',
        ]; 

    }

    public function messages(): array
    {
        return [
            'typesReceiptInvoice_id.required' => 'El campo es obligatorio',
            'number.required' => 'El campo es obligatorio',
            'number.unique' => 'El numero ya esta en uso',
            'customer_id.required' => 'El campo es obligatorio',
            'seller_id.required' => 'El campo es obligatorio',
            'date_elaboration.required' => 'El campo es obligatorio',
            'date_elaboration.after_or_equal' => 'Este campo tiene que ser despues de '.Carbon::now()->subDays(9)->format('Y-m-d').' y hasta '.Carbon::now()->format('Y-m-d'),
            'date_elaboration.before_or_equal' => 'Este campo tiene que ser despues de '.Carbon::now()->subDays(9)->format('Y-m-d').' y hasta '.Carbon::now()->format('Y-m-d'),
            'currency_id.required' => 'El campo es obligatorio',
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
