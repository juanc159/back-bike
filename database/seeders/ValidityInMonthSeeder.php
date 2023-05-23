<?php

namespace Database\Seeders;

use App\Models\ValidityInMonth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValidityInMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "number"=>'6',
                "name"=>'6 meses'
            ],
            [
                "id"=>2,
                "number"=>'12',
                "name"=>'12 meses'
            ],
            [
                "id"=>3,
                "number"=>'18',
                "name"=>'18 meses'
            ],
            [
                "id"=>4,
                "number"=>'24',
                "name"=>'24 meses'
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new ValidityInMonth();
            $data->id =  $value["id"];
            $data->number =  $value["number"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
