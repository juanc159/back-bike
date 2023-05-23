<?php

namespace Database\Seeders;

use App\Models\PayrollGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayrollGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id" => 1,
                "name" => 'Administración'
            ],
            [
                "id" => 2,
                "name" => 'Producción'
            ],
            [
                "id" => 3,
                "name" => 'Ventas'
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new PayrollGroup();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
