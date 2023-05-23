<?php

namespace Database\Seeders;

use App\Models\ContributingSubType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContributingSubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id" => 1,
                "name" => 'Sin subtipo'
            ],
            [
                "id" => 2,
                "name" => 'Dependiente pensionado por vejez activo'
            ],
            [
                "id" => 3,
                "name" => 'Cotizante no obligado a cotización a pensión por edad'
            ],
            [
                "id" => 4,
                "name" => 'Cotizante con requisitos cumplidos para pensión'
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new ContributingSubType();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
