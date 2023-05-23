<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            "Ahorro",
            "Corriente"
        ];

        foreach ($arrayData as $key => $value) {
            $data = new AccountType(); 
            $data->name =  $value;
            $data->save();
        }
    }
}
