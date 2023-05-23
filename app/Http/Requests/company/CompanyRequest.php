<?php

namespace App\Http\Requests\company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CompanyRequest extends FormRequest
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
            'name' => 'required|max:30|min:3',
            'email' => 'required|regex:"^[^@]+@[^@]+\.[a-zA-Z]{2,}$"',
            'nit' => 'required|min:8|max:10',
            'phone' => 'required|min:10|max:15',
            'address' => 'required',
            'logo' => 'required',
            'identification_rep' => 'required|min:8|max:15',
            'address_rep' => 'required|min:2|max:50',
            'email_rep' => 'required|regex:"^[^@]+@[^@]+\.[a-zA-Z]{2,}$"',
            //'description' => 'required',
            'nameLegalRepresentative' => 'required|min:6',
            'phoneLegalRepresentative' => 'required|min:10|max:15',
            'startDate' => 'required|date_format:Y-m-d|before:'.'endDate',
            'endDate' => 'required',
        ];
        if(!empty($this->id)){
            unset($rule['logo']);
        }
        return $rule;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo es obligatorio',
            'name.max' => 'El campo debe tener máximo 30 caracteres',
            'name.min' => 'El campo debe tener mínimo 3 caracteres',
            'logo.required' => 'El campo es obligatorio', 
            'email.required' => 'El campo es obligatorio',
            'email.regex' => 'El Correo debe contener un @ y una extensión',
            'nit.required' => 'El campo es obligatorio',
            'nit.min' => 'El campo debe tener minimo 8 caracteres',
            'nit.max' => 'El campo debe tener maximo 10 caracteres',
            'phone.required' => 'El campo es obligatorio',
            'phone.min' => 'El campo debe tener minimo 10 caracteres',
            'phone.max' => 'El campo debe tener maximo 15 caracteres',
            'address.required' => 'El campo es obligatorio',
            //'description.required' => 'El campo es obligatorio',
            'nameLegalRepresentative.required' => 'El campo es obligatorio',
            'nameLegalRepresentative.min' => 'El campo debe tener minimo 6 caracteres',
            'phoneLegalRepresentative.required' => 'El campo es obligatorio',
            'phoneLegalRepresentative.min' => 'El campo debe tener minimo 10 caracteres',
            'phoneLegalRepresentative.max' => 'El campo debe tener maximo 15 caracteres',
            'startDate.required' => 'El campo es obligatorio',
            'startDate.before' => 'El campo fecha inicial debe ser menor a la fecha final',
            'startDate.date_format' => 'El campo fecha inicial debe ser una fecha válida',
            'endDate.required' => 'El campo es obligatorio',
            'identification_rep.required' => 'El campo es obligatorio',
            'address_rep.required' => 'El campo es obligatorio',
            'email_rep.required' => 'El campo es obligatorio',
            'identification_rep.min' => 'El campo debe tener minimo 8 caracteres',
            'identification_rep.max' => 'El campo debe tener maximo 15 caracteres',
            'address_rep.min' => 'El campo debe tener minimo 2 caracteres',
            'address_rep.max' => 'El campo debe tener maximo 50 caracteres',
            'address_rep.required' => 'El campo es obligatorio',
            'email_rep.regex' => 'El Correo debe contener un @ y una extensión',
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
