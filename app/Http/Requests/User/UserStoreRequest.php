<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class UserStoreRequest extends FormRequest
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
            "name" => "required", 
            'email' => 'required|regex:"^[^@]+@[^@]+\.[a-zA-Z]{2,}$"',
            "role_id" => "required", 
            "identification" => "required|max:15|min:5", 
            "phone" => "required|max:15|min:10", 
        ];
        if(!$this->id){
            $rule["password"] = "required";
        }
        return $rule;
    }

    public function messages(): array
    {
        return [
            "name.required" => "El campo es obligatorio",
            "email.required" => "El campo es obligatorio",
            'email.regex' => 'El Correo debe contener un @ y una extensión',
            "password.required" => "El campo es obligatorio",
            "role_id.required" => "El campo es obligatorio",
            'identification.required' => 'El campo es obligatorio',
            'phone.required' => 'El campo es obligatorio',
            'identification.max' => 'El campo debe contener máximo 15 caracteres',
            'identification.min' => 'El campo debe contener mínimo 5 caracteres',
            'phone.max' => 'El campo debe contener máximo 15 caracteres',
            'phone.min' => 'El campo debe contener mínimo 10 caracteres',
            // "company_id.required" => "El campo es obligatorio",
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
