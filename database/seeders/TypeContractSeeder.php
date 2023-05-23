<?php

namespace Database\Seeders;

use App\Models\TypeContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Indefinido'
            ],
            [
                "id"=>2,
                "name"=>'Fijo'
            ],
            [
                "id"=>3,
                "name"=>'Obra Labor'
            ],
            [
                "id"=>4,
                "name"=>'Aprendiz SENA en etapa de entrenamiento'
            ],
            [
                "id"=>5,
                "name"=>'Aprendiz SENA en etapa de productiva'
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new TypeContract();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
