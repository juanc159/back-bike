<?php

namespace Database\Seeders;

use App\Models\PensionFund;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PensionFundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [ 
            "Caxodac",
            "Old Mutual",
            "Old Mutual Alternativo",
            "Pensiones de Antioquia",
            "Porvenir S.A",
            "Protección S.A",
            "Colfondos",
            "Colpensiones ",
            "Fonprecon",
        ];


        foreach ($arrayData as $key => $value) {
            $data = new PensionFund(); 
            $data->name =  $value;
            $data->save();
        }
    }
}
