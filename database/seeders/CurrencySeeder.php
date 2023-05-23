<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id"=>1,
                "name"=>"EUR-Euro",
            ],
            [
                "id"=>2,
                "name"=>"USD- Dólar Estadounidense",                 
            ],
            [
                "id"=>3,
                "name"=>"CLP- Peso chileno",                 
            ],
            [
                "id"=>4,
                "name"=>"AED- Dirham de los Emiratos Árabes Unidos",                 
            ],
            [
                "id"=>5,
                "name"=>"ANG- Florín antillano neerlandés",                
            ],
            [
                "id"=>6,
                "name"=>"ARS-Peso argentino",                  
            ],
            [
                "id"=>7,
                "name"=>"AUD-Dólar australiano",                  
            ],
            [
                "id"=>8,
                "name"=>"BOB-Boliviano",                 
            ],
            [
                "id"=>9,
                "name"=>"BRL-Real Brasileño",                 
            ],
            [
                "id"=>10,
                "name"=>"CAD- Dólar canadiense",                 
            ],
            [
                "id"=>11,
                "name"=>"CHF-Franco Suizo",                 
            ],
            [
                "id"=>12,
                "name"=>"CNY-Yuan chino",                 
            ],
            [
                "id"=>13,
                "name"=>"CRC- Colón costarricense",                 
            ],
            [
                "id"=>14,
                "name"=>"DOP- Peso dominicano",                 
            ],
            [
                "id"=>15,
                "name"=>"GBP- Libra esterlina",                 
            ],
            [
                "id"=>16,
                "name"=>"GTQ-Quetzal guatemalteco",                 
            ],
            [
                "id"=>17,
                "name"=>"HNL- Lempira hondureño",                 
            ],
            [
                "id"=>18,
                "name"=>"HUF- Forint húngaro",                 
            ],
            [
                "id"=>19,
                "name"=>"JPY- Yen japonés",                 
            ],
            [
                "id"=>20,
                "name"=>"MXN- Peso mexicano",                 
            ],
            [
                "id"=>21,
                "name"=>"NZD- Dólar neozelandés",                 
            ],
            [
                "id"=>22,
                "name"=>"PAB- Balboa panameño",                 
            ],
            [
                "id"=>23,
                "name"=>"PEN- Sol peruano",                 
            ],
            [
                "id"=>24,
                "name"=>"PYG Guaraní paraguayo",                 
            ],
            [
                "id"=>25,
                "name"=>"SGD- Dólar de Singapur",                 
            ],
            [
                "id"=>26,
                "name"=>"SVC- Colón salvadoreño",                 
            ],
            [
                "id"=>27,
                "name"=>"UYU- Peso uruguayo",                 
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new Currency();
            $data->name =  $value['name'];
            $data->save();
        }
    }
}
