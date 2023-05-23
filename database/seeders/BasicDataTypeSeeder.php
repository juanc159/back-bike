<?php

namespace Database\Seeders;

use App\Models\BasicDataType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicDataTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Es persona'
            ],
            [
                "id"=>2,
                "name"=>'Empresa'
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new BasicDataType();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
