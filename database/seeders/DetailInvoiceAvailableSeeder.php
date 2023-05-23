<?php

namespace Database\Seeders;

use App\Models\DetailInvoiceAvailable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailInvoiceAvailableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id" => 1,
                "name" => "% Des.",
            ],
             [
                 "id" => 2,
                "name" => "Bodega",
                
            ],
            
            [
                "id" => 3,
                "name" => "Código",
            ],
            [
                "id" => 4,
                "name" => "Código arancelario",
            ],
            [
                "id" => 5,
                "name" => "impuesto cargo",
            ],
            [
                "id" => 6,
                "name" => "Impuesto cargo dos",
            ],
            [
                "id" => 7,
                "name" => "Impuesto retención",
            ],
            [
                "id" => 8,
                "name" => "Marca",
            ],
            [
                "id" => 9,
                "name" => "Módelo",
            ],
            [
                "id" => 10,
                "name" => "Nombre producto",
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
                "name" => "Referencia de fabrica",
            ],
            [
                "id" => 15,
                "name" => "unidad de medida",
            ],
            [
                "id" => 16,
                "name" => "Valor Impto. Rete.",
            ],
            [
                "id" => 17,
                "name" => "Valor Unitario",
            ],
            [
                "id" => 18,
                "name" => "Valor Bruto",
            ],
            [
                "id" => 19,
                "name" => "Valor descuento",
            ],
            [
                "id" => 20,
                "name" => "Valor impuesto cargo",
            ],
            [
                "id" => 21,
                "name" => "Valor impuesto cargo dos",
            ],
            [
                "id" => 22,
                "name" => "Vendedor",
            ],
        ];
        foreach ($arrayData as $key => $value) { 
            $data = new DetailInvoiceAvailable();  
            $data->id = $value["id"];
            $data->name =  $value["name"]; 
            $data->save();
        }
    }
}
