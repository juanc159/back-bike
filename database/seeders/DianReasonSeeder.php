<?php

namespace Database\Seeders;

use App\Models\DianReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DianReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Devolución de parte de los bienes; no aceptación de partes del servicio'
            ],
            [
                "id"=>2,
                "name"=>'Anulación de factura electrónica'
            ],
            [
                "id"=>3,
                "name"=>'Rebaja o decuento parcial o total'
            ],
            [
                "id"=>4,
                "name"=>'Ajuste de precio'
            ],
            [
                "id"=>5,
                "name"=>'Otros'
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new DianReason();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
