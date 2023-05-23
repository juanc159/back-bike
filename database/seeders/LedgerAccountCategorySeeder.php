<?php

namespace Database\Seeders;

use App\Models\LedgerAccountCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LedgerAccountCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id"=>1,
                "name"=>"Caja - Bancos",
            ],
            [
                "id"=>2,
                "name"=>"Cuentas por cobrar",
            ],
            [
                "id"=>3,
                "name"=>"Otros activos corrientes",
            ],
            [
                "id"=>4,
                "name"=>"Inventarios",
            ],
            [
                "id"=>5,
                "name"=>"Activos fijos",
            ],
            [
                "id"=>6,
                "name"=>"Otros activos",
            ],
            [
                "id"=>7,
                "name"=>"Cuentas por pagar",
            ],
            [
                "id"=>8,
                "name"=>"Otros pasivos corrientes",
            ],
            [
                "id"=>9,
                "name"=>"Pasivo corto plazo",
            ],
            [
                "id"=>10,
                "name"=>"Pasivos largos plazos",
            ],
            [
                "id"=>11,
                "name"=>"Otros pasivos",
            ],
            [
                "id"=>12,
                "name"=>"Patrinomio",
            ],
            [
                "id"=>13,
                "name"=>"Ingresos",
            ],
            [
                "id"=>14,
                "name"=>"Otros ingresos",
            ],
            [
                "id"=>15,
                "name"=>"Costo de ventas",
            ],
            [
                "id"=>16,
                "name"=>"Gastos",
            ],
            [
                "id"=>17,
                "name"=>"Otros gastos",
            ],
            [
                "id"=>18,
                "name"=>"Orden",
            ],
            [
                "id"=>19,
                "name"=>"Gasto - Nómina",
            ],
        ];
        foreach ($arrayData as $key => $value) {
            $data = new LedgerAccountCategory();
            $data->id = $value["id"];
            $data->name = $value["name"];
            $data->save();
        }
    }
}
