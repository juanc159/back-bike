<?php

namespace Database\Seeders;

use App\Models\PerformA;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerformASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Abono a deuda',                
            ],
            [
                "id"=>2,
                "name"=>'Anticipo',                
            ],
            [
                "id"=>3,
                "name"=>'Avanzado( impuesto, descuentos y ajustes)',
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new PerformA();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
