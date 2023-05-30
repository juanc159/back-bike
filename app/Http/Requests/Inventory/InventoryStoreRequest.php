<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InventoryStoreRequest extends FormRequest
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
            "reference" => "required",
            "brand" => "required",
            "model" => "required",
            "color" => "required",
            "plate" => "required",
            "registrationSite" => "required",
            "purchaseValue" => "required",
            "saleValue" => "required"
        ]; 

        return $rule;
    }

    public function messages(): array
    {
        return [   
            'reference.required' => 'El campo es obligatorio',  
            'brand.required' => 'El campo es obligatorio',  
            'model.required' => 'El campo es obligatorio',  
            'color.required' => 'El campo es obligatorio',  
            'plate.required' => 'El campo es obligatorio',  
            'registrationSite.required' => 'El campo es obligatorio',  
            'purchaseValue.required' => 'El campo es obligatorio',  
            'saleValue.required' => 'El campo es obligatorio',  
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
