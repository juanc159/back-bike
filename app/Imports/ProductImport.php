<?php

namespace App\Imports;

use App\Http\Resources\PayrollEmployeeResource;
use App\Models\Employee;
use App\Models\GeneralParametrization;
use App\Models\PayrollEmployee;
use App\Models\Product;
use App\Models\TaxCharge;
use App\Models\TaxClassification;
use App\Models\TypeProduct;
use App\Models\WithholdingTaxe;
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
class ProductImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    private $data;
    public $dataErrors = [];
    public $dataInfo = [];
    private $i = 0;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function model(array $row)
    {
        $register = new Product();
        $register->company_id = $this->data['company_id'];
        $register->typeProduct_id = $row['typeProduct_id'];
        $register->code = $row['code'];
        $register->ivaIncluded = $row['ivaIncluded'];
        $register->name = $row['name'];
        $register->price = $row['price'];
        $register->taxCharge_id = $row['taxCharge_id'];
        $register->unitOfMeasurement_id = $row['unitOfMeasurement_id'];
        $register->unitOfMeasurement = $row['unitOfMeasurement'];
        $register->factoryReference = $row['factoryReference'];
        $register->barcode = $row['barcode'];
        $register->description = $row['description'];
        $register->taxClassification_id = $row['taxClassification_id'];
        $register->withholdingTaxes_id = $row['withholdingTaxes_id'];
        $register->valueInpoconsumo = $row['valueInpoconsumo'];
        $register->applyConsumptionTax = $row['applyConsumptionTax'];
        $register->model = $row['model'];
        $register->tariffCode = $row['tariffCode'];
        $register->mark = $row['mark'];
        $register->state = $row['state'];
        $register->make();
        $this->dataInfo[] = $register;

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
            'typeProduct_id' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo tipo de producto debe ser un valor numérico');
                    } else {
                        $employee = TypeProduct::find($value);
                        if (empty($employee)) {
                            $onFailure('No existe ningun registro de tipo de producto con el identificador ' . $value);
                        }
                    }
                } else {
                    $onFailure('El campo tipo de producto no puede estar vacio');
                }
            },
            'code' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campos código no puede estar vacio');
                }
            },
            'ivaIncluded' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo iva incluido no puede estar vacio');
                }
            },
            'name' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo nombre no puede estar vacio');
                }
            },
            'price' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo precio no puede estar vacio');
                }
            },
            'taxCharge_id' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo impuesto cargo debe ser un valor numérico');
                    } else {
                        $employee = TaxCharge::find($value);
                        if (empty($employee)) {
                            $onFailure('No existe ningun registro de impuesto cargo con el identificador ' . $value);
                        }
                    }
                } else {
                    $onFailure('El campo impuesto cargo no puede estar vacio');
                }
            },
            'unitOfMeasurement_id' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo unidad de medida debe ser un valor numérico');
                    } else {
                        $employee = TaxCharge::find($value);
                        if (empty($employee)) {
                            $onFailure('No existe ningun registro de unidad de medida con el identificador ' . $value);
                        }
                    }
                } else {
                    $onFailure('El campo unidad de medida no puede estar vacio');
                }
            },
            'unitOfMeasurement' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo valor unidad de medida no puede estar vacio');
                }
            },
            'factoryReference' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo referencia de fábrica no puede estar vacio');
                }
            },
            'barcode' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo código de barra no puede estar vacio');
                }
            },
            'description' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo descripción no puede estar vacio');
                }
            },
            'taxClassification_id' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo clasificación fiscal debe ser un valor numérico');
                    } else {
                        $employee = TaxClassification::find($value);
                        if (empty($employee)) {
                            $onFailure('No existe ningun registro de clasificación fiscal con el identificador ' . $value);
                        }
                    }
                } else {
                    $onFailure('El campo clasificación fiscal no puede estar vacio');
                }
            },
            'withholdingTaxes_id' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (!empty($value) || $value === '0') {
                    if (!is_numeric($value)) {
                        $onFailure('El campo retención de impuestos debe ser un valor numérico');
                    } else {
                        $employee = WithholdingTaxe::find($value);
                        if (empty($employee)) {
                            $onFailure('No existe ningun registro de retención de impuestos con el identificador ' . $value);
                        }
                    }
                } else {
                    $onFailure('El campo retención de impuestos no puede estar vacio');
                }
            },
            'valueInpoconsumo' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo valor impoconsumo no puede estar vacio');
                }
            },
            'applyConsumptionTax' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo aplicar impuesto al consumo no puede estar vacio');
                }
            },
            'model' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo  modelo no puede estar vacio');
                }
            },
            'tariffCode' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo código de tarifa no puede estar vacio');
                }
            },
            'mark' => function ($attribute, $value, $onFailure) {
                $value = trim($value);
                if (empty($value)) {
                    $onFailure('El campo marca no puede estar vacio');
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
                $this->dataErrors[$this->i]['errors'] = $value2 ?? '';
                $this->dataErrors[$this->i]['values'] = $value->values()[$value->attribute()] ?? "vacio";
                $this->i++;
            }
        }
    }
    public function onError(\Throwable $e)
    {
        dd($e);
    }
}
