<?php

namespace Database\Seeders;
 
use App\Models\DetailQuoteAvailables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailQuoteAvailableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id" => 1,
                "name" => "Código",
            ],
             [
                 "id" => 2,
                "name" => "Imagen",
                
            ], 
            [
                "id" => 3,
                "name" => "Impuesto Cargo",
            ],
            [
                "id" => 4,
                "name" => "Impuesto Retención",
            ],
            [
                "id" => 5,
                "name" => "Nombre Producto",
            ],
            [
                "id" => 6,
                "name" => "Referencia de fábrica",
            ],
            [
                "id" => 7,
                "name" => "Unidad de medida",
            ],
            [
                "id" => 8,
                "name" => "Valor Unitario",
            ],
            [
                "id" => 9,
                "name" => "Valor Bruto",
            ],
            [
                "id" => 10,
                "name" => "Valor Descuento",
            ],
            [
                "id" => 11,
                "name" => "A1 Descripción",
            ],
            [
                "id" => 12,
                "name" => "A2 Cantidad",
            ],
            [
                "id" => 13,
                "name" => "A3 Valor",
            ],
            [
                "id" => 14,
                "name" => "Video",
            ]
        ];
        foreach ($arrayData as $key => $value) { 
            $data = new DetailQuoteAvailables();  
            $data->id = $value["id"];
            $data->name =  $value["name"]; 
            $data->save();
        }
    }
}
