<?php

namespace Database\Seeders;

use App\Models\FiscalResponsability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiscalResponsabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'0-13',
                "description"=>"Gran contribuyente"
            ],
            [
                "id"=>2,
                "name"=>'0-15',
                "description"=>"Autorretenedor"
            ],
            [
                "id"=>3,
                "name"=>'0-23',
                "description"=>"Agente de retención IVA"
            ],
            [
                "id"=>4,
                "name"=>'0-47',
                "description"=>"Régimen simple de tributación"
            ],
            [
                "id"=>5,
                "name"=>'R-99-PN',
                "description"=>"No aplica - Otros"
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new FiscalResponsability();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->description =  $value["description"];
            $data->save();
        }
    }
}
