<?php

namespace Database\Seeders;

use App\Models\TypeOfThird;
use App\Models\TypeProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Producto',
                "description" => 'Es la mercancia que tienes para la venta y/o proceso productivo.'
            ],
            [
                "id"=>2,
                "name"=>'Servicio',
                "description" => 'Son aquellos productos intangiblesque ofrezcas a tus clientes.'
            ],
            [
                "id"=>3,
                "name"=>'Consumo Interno',
                "description" => 'Son aquellos productos que compras para desarrollar la actividad de tu empresa.'
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new TypeProduct();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->description =  $value["description"];
            $data->save();
        }
    }
}
