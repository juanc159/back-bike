<?php

namespace Database\Seeders;

use App\Models\Arl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            "Alfa",
            "Colmena",
            "Colpatria ARP",
            "La Equidad Seguros",
            "Mapfre Colombia Vida Seguros S.A",
            "Positiva Compañía de Seguros",
            "Seguros Bolívar",
            "Seguros de riesgos laborales suramericana S.A",
            "Seguros de Vida Aurora",
            "Liberty",
        ];

        foreach ($arrayData as $key => $value) {
            $data = new Arl(); 
            $data->name =  $value;
            $data->save();
        }
    }
}
