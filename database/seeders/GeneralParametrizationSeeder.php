<?php

namespace Database\Seeders;

use App\Models\GeneralParametrization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralParametrizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Auxiliar transporte',
                "value"=>'140000'
            ],
            [
                "id"=>2,
                "name"=>'Porcentaje salud empleado',
                "value"=>'4'
            ],
            [
                "id"=>3,
                "name"=>'Porcentaje pensión empleado',
                "value"=>'4'
            ],
            [
                "id"=>'4',
                "name"=>'Pensión empleador',
                "value"=>'12'
            ],
            [
                "id"=>5,
                "name"=>'Caja de compensación empleador',
                "value"=>'4'
            ],
            [
                "id"=>6,
                "name"=>'Cesantías',
                "value"=>'8.33'
            ],
            [
                "id"=>7,
                "name"=>'Interes cesantías',
                "value"=>'12'
            ],
            [
                "id"=>8,
                "name"=>'Vacaciones',
                "value"=>'4.17'
            ],
            [
                "id"=>9,
                "name"=>'Salario mínimo',
                "value"=>'1160000'
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new GeneralParametrization();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->value =  $value["value"];
            $data->save();
        }
    }
}
