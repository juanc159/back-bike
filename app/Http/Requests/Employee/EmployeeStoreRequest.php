<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EmployeeStoreRequest extends FormRequest
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
        $rule1 = [
            "name" => "required|max:50",
            "last_name" => "required|max:50",
            "type_identifications_id" => "required",
            "document_number" => "required|max:15",
            "email" => "required|regex:'^[^@]+@[^@]+\.[a-zA-Z]{2,}$'",
            "company_id" => "required",
            "cellPhoneNumber" => "required|max:10",
            "residenceAddress" => "required|max:100",
            "residenceDepartament_id" => "required",
            "residenceCity_id" => "required",
            "officeDepartament_id" => "required",
            "officeCity_id" => "required",
            "residenceOffice" => "required|max:100",
            "paymentMethod_id" => "required",
        ];
        if($this->paymentMethod_id==77){
            $rule1["kind_procedure_id"] = "required";
            $rule1["cellPhoneNumberPay"] = "required|max:10";
        }
        if($this->paymentMethod_id==78){
            $rule1["banking_entity_id"] = "required";
            $rule1["account_type_id"] = "required";
            $rule1["account_number"] = "required|max:20";
        } 
 
        return $rule1;   
    }

    public function messages(): array
    {
        return [
            "name.required" => "El campo es obligatorio",
            "name.max" => "El campo debe tener máximo 50 caracteres",
            "last_name.required" => "El campo es obligatorio",
            "last_name.max" => "El campo debe tener máximo 50 caracteres",
            "type_identifications_id.required" => "El campo es obligatorio",
            "document_number.required" => "El campo es obligatorio",
            "document_number.max" => "El campo debe tener máximo 15 caracteres",
            "email.required" => "El campo es obligatorio",
            "email.regex" => "El correo debe contener un @ y una extensión",
            "company_id.required" => "El campo es obligatorio",
            "cellPhoneNumber.required" => "El campo es obligatorio",
            "cellPhoneNumber.max" => "El campo debe tener máximo 10 caracteres",
            "residenceAddress.required" => "El campo es obligatorio",
            "residenceAddress.max" => "El campo debe tener máximo 100 caracteres",
            "residenceDepartament_id.required" => "El campo es obligatorio",
            "residenceCity_id.required" => "El campo es obligatorio",
            "officeDepartament_id.required" => "El campo es obligatorio",
            "officeCity_id.required" => "El campo es obligatorio",
            "residenceOffice.required" => "El campo es obligatorio",
            "residenceOffice.max" => "El campo debe tener máximo 100 caracteres",
            "paymentMethod_id.required" => "El campo es obligatorio",
            "kind_procedure_id.required" => "El campo es obligatorio",
            "cellPhoneNumberPay.required" => "El campo es obligatorio",
            "cellPhoneNumberPay.max" => "El campo debe tener máximo 10 caracteres",
            "banking_entity_id.required" => "El campo es obligatorio",
            "account_number.required" => "El campo es obligatorio",
            "account_number.max" => "El campo debe tener máximo 20 caracteres",
            "account_type_id.required" => "El campo es obligatorio",
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
