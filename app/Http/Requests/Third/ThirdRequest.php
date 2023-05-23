<?php

namespace App\Http\Requests\Third;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ThirdRequest extends FormRequest
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
            'name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'identifications' => 'required|max:50',
            'contact_name' => 'required',
            'branch_code' => 'max:3',
            'email_fac' => 'required',
            'basic_data_types_id' => 'required',
            'trade_name' => 'max:255',
            'address' => 'max:255',
            'departament_id' => 'required',
            'city_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo es obligatorio',
            'last_name.required' => 'El campo es obligatorio',
            'identifications.required' => 'El campo es obligatorio',
            'identifications.max' => 'El campo debe contener maximo 50 caracteres',
            'name.max' => 'El campo debe contener maximo 50 caracteres',
            'last_name.max' => 'El campo debe contener maximo 50 caracteres',
            'trade_name.max' => 'El campo debe contener maximo 50 caracteres',
            'address.max' => 'El campo debe contener maximo 255 caracteres',
            'branch_code.max' => 'El campo debe contener maximo 3 caracteres',
            'contact_name.required' => 'El campo es obligatorio',
            'email_fac.required' => 'El campo es obligatorio',
            'basic_data_types_id.required' => 'El campo es obligatorio',
            'departament_id.required' => 'El campo es obligatorio',
            'city_id.required' => 'El campo es obligatorio',
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
