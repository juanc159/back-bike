<?php

namespace Database\Seeders;

use App\Models\Arl;
use App\Models\TaxClassification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            "Excluido",
            "Exento",
            "Gravado",
        ];

        foreach ($arrayData as $key => $value) {
            $data = new TaxClassification(); 
            $data->name =  $value;
            $data->save();
        }
    }
}
