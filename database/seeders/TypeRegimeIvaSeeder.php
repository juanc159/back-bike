<?php

namespace Database\Seeders;

use App\Models\TypeRegimeIva;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeRegimeIvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'No responsable de IVA'
            ],
            [
                "id"=>2,
                "name"=>'Responsable de IVA'
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new TypeRegimeIva();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
