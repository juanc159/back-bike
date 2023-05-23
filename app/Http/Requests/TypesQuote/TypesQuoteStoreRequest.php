<?php

namespace App\Http\Requests\TypesQuote;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TypesQuoteStoreRequest extends FormRequest
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
 

            'initialNumbering' => 'required',
            'proxNumberQuote' => 'required|max:10', 

            'discountTypePerItem_id' => 'required',
             
            'format_id' => 'required',

            'titleForDisplay' => 'required|max:50',
            'header' => 'required|max:100',
            'conditionsObservations' => 'required|max:100',

            'subjectMail' => 'required',
            'contentMail' => 'required|max:100',
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
 

            'initialNumbering.required' => 'El campo es obligatorio',
            'proxNumberQuote.required' => 'El campo es obligatorio',
            'discountTypePerItem_id.required' => 'El campo es obligatorio',
            'format_id.required' => 'El campo es obligatorio',
            'titleForDisplay.required' => 'El campo es obligatorio',
            'titleForDisplay.max' => 'El campo debe contener maximo 50 caracteres',
            'header.required' => 'El campo es obligatorio',
            'header.max' => 'El campo debe contener maximo 100 caracteres',
            'conditionsObservations.required' => 'El campo es obligatorio',
            'conditionsObservations.max' => 'El campo debe contener maximo 100 caracteres',
            'subjectMail.required' => 'El campo es obligatorio',
            'contentMail.required' => 'El campo es obligatorio',
            'contentMail.max' => 'El campo debe contener maximo 100 caracteres',
 
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
