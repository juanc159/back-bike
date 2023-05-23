<?php

namespace Database\Seeders;

use App\Models\ReasonRetirement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReasonRetirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>' - '
            ],
            [
                "id"=>2,
                "name"=>'Mutuo acuerdo'
            ],
            [
                "id"=>3,
                "name"=>'Sin justa causa'
            ],
            [
                "id"=>4,
                "name"=>'Voluntario'
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new ReasonRetirement();
            $data->id =  $value["id"]; 
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
