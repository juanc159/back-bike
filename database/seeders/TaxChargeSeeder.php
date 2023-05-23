<?php

namespace Database\Seeders;

use App\Models\TaxCharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id"=>1,
                "name"=>"IVA 19%", 
                "value"=> 0.19,               
            ],
            [
                "id"=>2,
                "name"=>"Impoconsumo 8%", 
                "value"=> 0.08,                
            ],
            [
                "id"=>3,
                "name"=>"Impoconsumo por valor", 
                "value"=> 0,                
            ],
            [
                "id"=>4,
                "name"=>"IVA 5%",
                "value"=> 0.05,                 
            ],
            [
                "id"=>5,
                "name"=>"IVA 0%",
                "value"=> 0,                 
            ],
            [
                "id"=>6,
                "name"=>"IVA 5% compras", 
                "value"=> 0.05,                
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new TaxCharge();
            $data->name =  $value['name'];
            $data->value =  $value['value'];
            $data->save();
        }
    }
}
