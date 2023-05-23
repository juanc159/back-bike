<?php

namespace Database\Seeders;

use App\Models\ContributingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContributingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id" => 1,
                "name" => 'Dependiente-Contrato laboral'
            ],
            [
                "id" => 2,
                "name" => 'Aprendiz SENA en etapa entrenamiento'
            ],
            [
                "id" => 3,
                "name" => 'Aprendiz SENA en etapa productiva'
            ],
            [
                "id" => 4,
                "name" => 'Pensionado'
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new ContributingType();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
