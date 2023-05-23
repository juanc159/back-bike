<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RoleRequest extends FormRequest
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
            'name' => 'required|min:8|max:20',
            'description' => 'required|min:1|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo es obligatorio',
            'name.min' => 'El campo debe tener minimo 8 caracteres',
            'name.max' => 'El campo debe tener maximo 20 caracteres',
            'description.required' => 'El campo es obligatorio',
            'description.min' => 'El campo debe tener minimo 1 caracteres',
            'description.max' => 'El campo debe tener maximo 50 caracteres',
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
