<?php

namespace Database\Seeders;

use App\Models\TypeChargeAndDiscount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeChargeAndDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Cargo'
            ],
            [
                "id"=>2,
                "name"=>'Descuento'
            ]
        ];

        foreach ($arrayData as $key => $value) {
            $data = new TypeChargeAndDiscount();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
