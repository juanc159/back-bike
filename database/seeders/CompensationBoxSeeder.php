<?php

namespace Database\Seeders;

use App\Models\CompensationBox;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompensationBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            "Cafaba",
            "Cafam",
            "Cafamaz",
            "Cafasur",
            "Caja_Copi",
            "Cajamag",
            "Cajasai",
            "Cajasan",
            "Ccf De la guajira",
            "Ccf De Nariño",
            "Colsubsidio",
            "Camfaboy",
            "Combarranquilla",
            "cofacundi",
            "Comfenalco Quindio",
            "Comfenalco Santander",
            "Camfamiliar Cartagena",
            "Comfacesar",
            "Cofrem",
            "Camfamiliar Chocó",
            "Comfamiliar Huila",
            "Comfamiliar Risaralda",
            "Compensar",
            "Camfatolima",
        ];

        foreach ($arrayData as $key => $value) {
            $data = new CompensationBox(); 
            $data->name =  $value;
            $data->save();
        }
    }
}
