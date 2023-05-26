<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Third;
use Illuminate\Database\Seeder;

class ThirdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            'Mensajeria',
            'Impuestos',
            'Papeles',
            'Comisión',
            'Lavada',
            'Repuestos',
            'Taller',
            'LLantas',
            'Pintura',
            'Calcomanias'
        ];

        for ($i = 1; $i < 4; $i++) {
            foreach ($arrayData as $key => $value) {
                $data = new Third(); 
                $data->name = $value;
                $data->company_id = $i;
                $data->save();
            }
        }
    }
}
