<?php

namespace App\Http\Requests\WayToPay;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class WayToPayGeneralRequest extends FormRequest
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
        $rule = [ 
            'code' => 'required|max:20|unique:way_to_pay_generals,code,'.$this->id.',id,company_id,'.$this->company_id.'|unique:way_to_pay_pay_on_lines,code,'.$this->id.',id,company_id,'.$this->company_id,
            'name' => 'required|max:50|unique:way_to_pay_generals,name,'.$this->id.',id,company_id,'.$this->company_id.'|unique:way_to_pay_pay_on_lines,name,'.$this->id.',id,company_id,'.$this->company_id,
            'related_to_id' => 'required',
            'ledger_account_auxiliary_id' => 'required',
            'payment_method_id' => 'required',
        ];

        if($this->related_to_id==3){
            unset($rule["payment_method_id"]);
        }
        return $rule;
    }

    public function messages(): array
    {
        return [ 
            'code.unique' => 'El codigo ya esta en uso',
            'name.unique' => 'El nombre ya esta en uso',
            'code.required' => 'El campo es obligatorio',
            'name.required' => 'El campo es obligatorio',
            'related_to_id.required' => 'El campo es obligatorio',
            'ledger_account_auxiliary_id.required' => 'El campo es obligatorio',
            'payment_method_id.required' => 'El campo es obligatorio',            
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
