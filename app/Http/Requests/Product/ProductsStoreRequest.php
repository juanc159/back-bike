<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductsStoreRequest extends FormRequest
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
            'code' => 'required|max:30',
            'unitOfMeasurement' => 'required|max:50',
            'factoryReference' => 'required|max:80',
            'barcode' => 'required|max:80',
            'model' => 'required|max:100',
            'tariffCode' => 'required|max:10',
            'mark' => 'required|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'El campo es obligatorio',
            'code.max' => "El campo debe tener máximo 30 caracteres", 
            'unitOfMeasurement.required' => 'El campo es obligatorio',
            'unitOfMeasurement.max' => "El campo debe tener máximo 50 caracteres", 
            'factoryReference.required' => 'El campo es obligatorio',
            'factoryReference.max' => "El campo debe tener máximo 80 caracteres", 
            'barcode.required' => 'El campo es obligatorio',
            'barcode.max' => "El campo debe tener máximo 50 caracteres", 
            'model.required' => 'El campo es obligatorio',
            'model.max' => "El campo debe tener máximo 100 caracteres", 
            'tariffCode.required' => 'El campo es obligatorio',
            'tariffCode.max' => "El campo debe tener máximo 10 caracteres", 
            'mark.required' => 'El campo es obligatorio',
            'mark.max' => "El campo debe tener máximo 50 caracteres", 
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
