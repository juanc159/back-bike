<?php

namespace App\Http\Requests\ledgerAccount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SubAccountStoreRequest extends FormRequest
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
        return [
            'code' => 'required|min:6|max:6',
            //'code' => 'required|min:6|max:6|unique:ledger_account_groups,code,'.$this->id,
            'name' => 'required',
            'ledgerAccountClass_id' => 'required', 
            'ledgerAccountGroup_id' => 'required', 
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'El campo es obligatorio', 
            'code.min' => 'debe completar el codigo a 6 caracteres', 
            'code.max' => 'debe completar el codigo a 6 caracteres',
            'code.unique' => 'El codigo ya esta en uso',
            'name.required' => 'El campo es obligatorio', 
            'ledgerAccountClass_id.required' => 'El campo es obligatorio', 
            'ledgerAccountGroup_id.required' => 'El campo es obligatorio', 
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
