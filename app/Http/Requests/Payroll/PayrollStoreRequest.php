<?php

namespace App\Http\Requests\Payroll;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PayrollStoreRequest extends FormRequest
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
        return[
            'name' => 'required|max:50',
            'settlement_type' => 'required',
            'month' => 'required',
            'year' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo es obligatorio',
            'name.max' => "El campo debe tener máximo 50 caracteres",
            'settlement_type.required' => 'El campo es obligatorio',
            'month.required' => 'El campo es obligatorio',
            'year.required' => 'El campo es obligatorio',
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
