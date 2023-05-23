<?php

namespace App\Imports;

use App\Http\Resources\PayrollEmployeeResource;
use App\Models\Employee;
use App\Models\GeneralParametrization;
use App\Models\PayrollEmployee;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Str;

HeadingRowFormatter::default('none');
class PayrollImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $parametrizations;
    private $transport_assistance;
    private $health_percentage;
    private $pension_percentage;
    private $employeer_pension_percentage;
    private $employeer_compensation_box_percentage;
    private $layoffs_percentage;
    private $severance_interest_percentage;
    private $vacation_percentage;
    private $data;
    public $dataErrors = [];
    public $dataInfo = [];
    private $i = 0;
    public function __construct($data)
    {
        $this->data = $data;
        $this->parametrizations = GeneralParametrization::get();

        $this->transport_assistance = $this->parametrizations->firstWhere('id', 1);
        $this->transport_assistance = $this->transport_assistance->value ?? 0;

        $this->health_percentage = $this->parametrizations->firstWhere('id', 2);
        $this->health_percentage = $this->health_percentage->value ?? 0;

        $this->pension_percentage = $this->parametrizations->firstWhere('id', 3);
        $this->pension_percentage = $this->pension_percentage->value ?? 0;

        $this->employeer_pension_percentage = $this->parametrizations->firstWhere('id', 4);
        $this->employeer_pension_percentage = $this->employeer_pension_percentage->value ?? 0;

        $this->employeer_compensation_box_percentage = $this->parametrizations->firstWhere('id', 5);
        $this->employeer_compensation_box_percentage = $this->employeer_compensation_box_percentage->value ?? 0;

        $this->layoffs_percentage = $this->parametrizations->firstWhere('id', 6);
        $this->layoffs_percentage = $this->layoffs_percentage->value ?? 0;

        $this->severance_interest_percentage = $this->parametrizations->firstWhere('id', 7);
        $this->severance_interest_percentage = $this->severance_interest_percentage->value ?? 0;

        $this->vacation_percentage = $this->parametrizations->firstWhere('id', 8);
        $this->vacation_percentage = $this->vacation_percentage->value ?? 0;
    }
    public function model(array $row)
    {
        $employee = Employee::where('document_number', $row['Numero Identificacion'])->first();

        if ($employee) {
            $row['Dias Trabajados'] = $row['Dias Trabajados'] ?? 0;
            $row['Horas Extras'] = $row['Horas Extras'] ?? 0;
            $row['Bonificaciones'] = $row['Bonificaciones'] ?? 0;
            $row['Comisiones'] = $row['Comisiones'] ?? 0;
            $row['Otros Descuentos'] = $row['Otros Descuentos'] ?? 0;

            $wage = (($employee->workingInformation?->salary ?? 0) / 30) * $row['Dias Trabajados'];
            $amount_transport_assistance = ($this->transport_assistance / 30) * $row['Dias Trabajados'];
            $total_accrued = $wage + $this->transport_assistance + $row['Horas Extras'] + $row['Bonificaciones'] + $row['Comisiones'];
            $deduction_health = ($wage + $row['Horas Extras'] + $row['Comisiones']) * ($this->health_percentage / 100);
            $deduction_pension = ($wage + $row['Horas Extras'] + $row['Comisiones']) * ($this->pension_percentage / 100);
            $total_deductibles = $deduction_health + $deduction_pension + $row['Otros Descuentos'];
            $total_paid = $total_accrued - $total_deductibles;
            $employer_pension = $wage * ($this->employeer_pension_percentage / 100);
            $employer_compensation_box = $wage * ($this->employeer_compensation_box_percentage / 100);
            $employer_arl = $wage * ($employee->workingInformation?->risk_class?->value / 100);
            $total_form_pension = $deduction_pension + $employer_pension;
            $total_form_health = $deduction_health;
            $total_form_arl = $employer_arl;
            $total_form_compensation_box = $employer_compensation_box;
            $layoffs = ($wage + $amount_transport_assistance + $row['Horas Extras'] + $row['Comisiones']) * ($this->layoffs_percentage / 100);
            $severance_interest = $layoffs * ($this->severance_interest_percentage / 100);
            $wage_premium = $layoffs;
            $vacation = $wage * ($this->vacation_percentage / 100);
            $total_provisions = $layoffs + $severance_interest + $wage_premium + $vacation;

            $register = new PayrollEmployee();

            $register->payroll_id = $this->data['payroll_id'];
            $register->workedDays = $row['Dias Trabajados'];
            $register->extra_hours = $row['Horas Extras'];
            $register->bonuses = $row['Bonificaciones'];
            $register->commissions = $row['Comisiones'];
            $register->other_discounts = $row['Otros Descuentos'];
            $register->employee_id = $employee->id;
            $register->wage = $wage;
            $register->amount_transport_assistance = $amount_transport_assistance;
            $register->total_accrued = $total_accrued;
            $register->deduction_health = $deduction_health;
            $register->deduction_pension = $deduction_pension;
            $register->total_deductibles = $total_deductibles;
            $register->total_paid = $total_paid;
            $register->employer_pension = $employer_pension;
            $register->employer_compensation_box = $employer_compensation_box;
            $register->employer_arl = $employer_arl;
            $register->total_form_pension = $total_form_pension;
            $register->total_form_health = $total_form_health;
            $register->total_form_arl = $total_form_arl;
            $register->total_form_compensation_box = $total_form_compensation_box;
            $register->layoffs = $layoffs;
            $register->severance_interest = $severance_interest;
            $register->wage_premium = $wage_premium;
            $register->vacation = $vacation;
            $register->total_provisions = $total_provisions;
            $register->make();
            $this->dataInfo[] = $register;
        }
        return;
    }

    /* public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    } */
    public function rules(): array
    {
        return [
            'Numero Identificacion' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo dias trabajados debe ser un valor numerico');
                    } else {
                        $employee = Employee::where('document_number', $value)->first();
                        if (empty($employee)) {
                            $onFailure('No existe ningun registro empleados con numero documento ' . $value);
                        }
                    }
                } else {
                    $onFailure('El campos dias trabajados no puede estar vacio');
                }
            },
            'Dias Trabajados' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo dias trabajados debe ser un valor numerico');
                    }
                } else {
                    $onFailure('El campos dias trabajados no puede estar vacio');
                }
            },
            'Horas Extras' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo horas extras debe ser un valor numerico');
                    }
                } else {
                    $onFailure('El campos horas extras no puede estar vacio');
                }
            },
            'Bonificaciones' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo bonificaciones debe ser un valor numerico');
                    }
                } else {
                    $onFailure('El campos bonificaciones no puede estar vacio');
                }
            },
            'Comisiones' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo comisiones debe ser un valor numerico');
                    }
                } else {
                    $onFailure('El campos comisiones no puede estar vacio');
                }
            },
            'Otros Descuentos' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo otros descuentos debe ser un valor numerico');
                    }
                } else {
                    $onFailure('El campos otros descuentos no puede estar vacio');
                }
            },
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $key => $value) {
            foreach ($value->errors() as $key2 => $value2) {
                $this->dataErrors[$this->i]['row'] = $value->row();
                $this->dataErrors[$this->i]['attribute'] = $value->attribute();
                $this->dataErrors[$this->i]['errors'] = $value2;
                $this->dataErrors[$this->i]['values'] = $value->values()[$value->attribute()];
                $this->i++;
            }
        }
    }
    public function onError(\Throwable $e)
    {
        dd($e);
    }
}
