<?php

namespace Database\Seeders;

use App\Models\LedgerAccountClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LedgerAccountClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id" => 1,
                "code" => 1,
                "name" => "Activo",
            ],
            [
                "id" => 2,
                "code" => 2,
                "name" => "Pasivo",
            ],
            [
                "id" => 3,
                "code" => 3,
                "name" => "Patrimonio",
            ],
            [
                "id" => 4,
                "code" => 4,
                "name" => "Ingresos",
            ],
            [
                "id" => 5,
                "code" => 5,
                "name" => "Gasto",
            ],
            [
                "id" => 6,
                "code" => 6,
                "name" => "Costos de venta",
            ],
            [
                "id" => 7,
                "code" => 7,
                "name" => "Costos de producción",
            ],
            [
                "id" => 8,
                "code" => 8,
                "name" => "Cuentas de orden deudoras",
            ],
            [
                "id" => 9,
                "code" => 9,
                "name" => "Cuentas de orden acreedoras",
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new LedgerAccountClass();
            $data->id =  $value["id"];
            $data->code =  $value["code"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
