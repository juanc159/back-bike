<?php

namespace Database\Seeders;

use App\Models\UnitOfMeasurementInvoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitOfMeasurementInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id"=>1,
                "name"=>"94 unidades", 
                "unit"=> 94,               
            ],
            [
                "id"=>2,
                "name"=>"2I unidad térmica británica por hora", 
                "unit"=> 2,                
            ],
            [
                "id"=>3,
                "name"=>"A12 Unidad Astronómica", 
                "unit"=> 12,                
            ],
            [
                "id"=>4,
                "name"=>"A20 Unidad Térmica británica por segundo pie cuadrado grado Rankin",
                "unit"=> 20,                 
            ],
            [
                "id"=>5,
                "name"=>"A21 Unidad  térmica británica por libra grado Rankin",
                "unit"=> 21,                 
            ],
            [
                "id"=>6,
                "name"=>"A22 Unidad  térmica británica por segundo pie grado Rankin", 
                "unit"=> 22,                
            ],
            [
                "id"=>7,
                "name"=>"A23 Unidad  térmica británica por hora pie grado Rankin", 
                "unit"=> 23,                
            ],
            [
                "id"=>8,
                "name"=>"A77 Unidad de desplazamiento CGS Gaussiana", 
                "unit"=> 77,                
            ],
            [
                "id"=>9,
                "name"=>"A78 Unidad Gaussiana CGS de corriente eléctrica", 
                "unit"=> 78,                
            ],
            [
                "id"=>10,
                "name"=>"A79 Unidad Gaussiana CGS de carga eléctrica", 
                "unit"=> 79,                
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new UnitOfMeasurementInvoice();
            $data->id =  $value["id"];
            $data->name =  $value['name'];
            $data->unit =  $value['unit'];
            $data->save();
        }
    }
}
