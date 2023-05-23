<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EmployeeWorkingInformationRequest extends FormRequest
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
            "typeContract_id" => "required",
            "company_id" => "required",
            "contractStartDate" => "required",

            'contractFinalDate' => 'required|after:'.$this->contractStartDate,

            "salary" => "required",
            "comprehensive_salary" => "required",
            "contract_number" => "required",
            "payroll_group" => "required",
            "charge_id" => "required",
            "typeContributor_id" => "required",
            "subTypeContributor_id" => "required",
            "health_background_id" => "required",
            "health_fund_percentage" => "required",
            "pension_fund_id" => "required",
            "pension_fund_percentage" => "required",
            "arl_id" => "required",
            "risk_class_id" => "required",
            "code_ciiu" => "max:4",
            "code_id" => "max:4",
            "compensation_box_id" => "required",
            "severance_fund_id" => "required",
            "withholding_deductions" => "required",
            "reasonRetirement_id" => "required",
            "employee_id" => "required",
        ]; 
 
        return $rule1;   
    }

    public function messages(): array
    {
        return [
            "typeContract_id.required" => "El campo es obligatorio",
            "company_id.required" => "El campo es obligatorio",
            "contractStartDate.required" => "El campo es obligatorio",

            "contractFinalDate.required" => "El campo es obligatorio",
            'contractFinalDate.after' => 'El campo fecha fin de contrato debe ser mayor a la fecha inicial',

            "salary.required" => "El campo es obligatorio",
            "comprehensive_salary.required" => "El campo es obligatorio",
            "contract_number.required" => "El campo es obligatorio",
            "payroll_group.required" => "El campo es obligatorio",
            "charge_id.required" => "El campo es obligatorio",
            "typeContributor_id.required" => "El campo es obligatorio",
            "subTypeContributor_id.required" => "El campo es obligatorio",
            "health_background_id.required" => "El campo es obligatorio",
            "health_fund_percentage.required" => "El campo es obligatorio",
            "pension_fund_id.required" => "El campo es obligatorio",
            "pension_fund_percentage.required" => "El campo es obligatorio",
            "arl_id.required" => "El campo es obligatorio",
            "risk_class_id.required" => "El campo es obligatorio",
            "code_ciiu.max" => "El campo debe tener máximo 4 caracteres",
            "code_id.max" => "El campo debe tener máximo 4 caracteres",
            "compensation_box_id.required" => "El campo es obligatorio",
            "severance_fund_id.required" => "El campo es obligatorio",
            "withholding_deductions.required" => "El campo es obligatorio",
            "reasonRetirement_id.required" => "El campo es obligatorio",
            "employee_id.required" => "El campo es obligatorio",
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
