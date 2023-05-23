<?php

namespace Database\Seeders;

use App\Models\StatesQuote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatesQuoteSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id"=>1,
                "name"=>"Borrador",           
            ],
            [
                "id"=>2,
                "name"=>"Aprobada",           
            ],
            [
                "id"=>3,
                "name"=>"Anulada",           
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new StatesQuote();
            $data->name =  $value['name'];
            $data->save();
        }
    }
}
