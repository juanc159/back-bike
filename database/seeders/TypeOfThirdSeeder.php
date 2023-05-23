<?php

namespace Database\Seeders;

use App\Models\TypeOfThird;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeOfThirdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Clientes',
                "description" => 'Personas o empresas a las cuales necesitas generarles una
                cotización y/o una factura de venta.'
            ],
            [
                "id"=>2,
                "name"=>'Proveedores',
                "description" => 'Todas las personas o empresas a las cuales les compras bienes o
                servicios.'
            ],
            [
                "id"=>3,
                "name"=>'Otros',
                "description" => 'Por ejemplo. Fondos de salud y pensión, bancos, etc.'
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new TypeOfThird();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->description =  $value["description"];
            $data->save();
        }
    }
}
