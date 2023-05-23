<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $data = new Company();  
        $data->name = 'NyGsoft';
        $data->email = 'nygsoft@gmail.com';
        $data->nit = '123456789';
        $data->phone = '04147206169';
        $data->address = 'Kenedy';
        $data->user_id = 1;
        $data->description = 'Empresa desarrollo de software';
        $data->nameLegalRepresentative = 'Nelson Barbosa';
        $data->phoneLegalRepresentative = '04146548721';
        $data->identification_rep = '64555646546';
        $data->email_rep = 'repre@gmail.com';
        $data->address_rep = 'caracas';
        $data->startDate = '2023-03-03';
        $data->endDate = '2030-03-03';
        $data->logo = "null";
        $data->headerReport = null;
        $data->footerReport = null;
        $data->save();
    }
}
