<?php

namespace Database\Seeders;

use App\Models\RiskClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiskClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id"=>1,
                "name"=>"Categoría I-0.522",
                "value"=>'0.522'
            ],
            [
                "id"=>2,
                "name"=>"Categoría II-1.044",
                "value"=>'1.044'
            ],
            [
                "id"=>3,
                "name"=>"Categoría III- 2.436",
                "value"=>'2.436'
            ],
            [
                "id"=>4,
                "name"=>"Categoría IV-4.35",
                "value"=>'4.350'
            ],
            [
                "id"=>5,
                "name"=>"Categoría V- 6.96",
                "value"=>'6.96'
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new RiskClass();
            $data->name =  $value['name'];
            $data->value =  $value['value'];
            $data->save();
        }
    }
}
