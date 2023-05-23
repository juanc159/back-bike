<?php

namespace Database\Seeders;

use App\Models\LedgerAccountBalance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LedgerAccountBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                "id"=>1,
                "name"=>"Sin detalle de vencimiento",
            ],
            [
                "id"=>2,
                "name"=>"Cliente controla vencimiento y estado de cuenta",
            ],
            [
                "id"=>3,
                "name"=>"Proveedores, controla vencimiento y estado de cuenta",
            ],            
        ];
        foreach ($arrayData as $key => $value) {
            $data = new LedgerAccountBalance();
            $data->id = $value["id"];
            $data->name = $value["name"];
            $data->save();
        }
    }
}
