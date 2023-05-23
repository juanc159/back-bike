<?php

namespace Database\Seeders;

use App\Models\WithholdingTaxe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WithholdingTaxeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id"=>1,
                "name"=>"Retefuente 3.5%", 
                "value"=> 0.035,                
            ],
            [
                "id"=>2,
                "name"=>"Retefuente 7%", 
                "value"=> 0.07,                
            ],
            [
                "id"=>3,
                "name"=>"Retefuente 2%", 
                "value"=> 0.02,                
            ],
            [
                "id"=>4,
                "name"=>"Retefuente 1%", 
                "value"=> 0.01,                
            ],
            [
                "id"=>5,
                "name"=>"Retefuente 3.5% Arrendamientos",
                "value"=> 0.035,                 
            ],
            [
                "id"=>6,
                "name"=>"Retefuente 11%",  
                "value"=> 0.11,               
            ],
            [
                "id"=>7,
                "name"=>"Retefuente 10%",  
                "value"=> 0.1,               
            ],
            [
                "id"=>8,
                "name"=>"Retefuente 6%", 
                "value"=> 0.06,                
            ],
            [
                "id"=>9,
                "name"=>"Retefuente 4%", 
                "value"=> 0.04,                
            ],
            [
                "id"=>10,
                "name"=>"Retefuente 2.5%", 
                "value"=> 0.025,                
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new WithholdingTaxe();
            $data->name =  $value['name'];
            $data->value =  $value['value'];
            $data->save();
        }
    }
}
