<?php

namespace Database\Seeders;

use App\Models\RelatedTo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelatedToSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Cartera/Proveedores',
            ],
            [
                "id"=>2,
                "name"=>'Cartera - Factura de venta y Recibo de pago',
            ],
            [
                "id"=>3,
                "name"=>'Proveedores - Factura de compra y Recibo de pago',
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new RelatedTo();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
