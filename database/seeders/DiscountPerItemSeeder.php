<?php

namespace Database\Seeders;

use App\Models\DiscountPerItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountPerItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Porcentaje'
            ],
            [
                "id"=>2,
                "name"=>'Valor'
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new DiscountPerItem();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
