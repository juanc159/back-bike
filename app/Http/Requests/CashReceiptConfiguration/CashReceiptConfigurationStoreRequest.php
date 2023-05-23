<?php

namespace App\Http\Requests\CashReceiptConfiguration;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class CashReceiptConfigurationStoreRequest extends FormRequest
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
            "code" => "required", 
            "title" => "required", 
            "description" => "required",  
            "consecutive" => "required", 
            "subject" => "required", 
        ];
    }

    public function messages(): array
    {
        return [
            "code.required" => "El campo es obligatorio", 
            "title.required" => "El campo es obligatorio", 
            "description.required" => "El campo es obligatorio", 
            "consecutive.required" => "El campo es obligatorio", 
            "subject.required" => "El campo es obligatorio",  
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
