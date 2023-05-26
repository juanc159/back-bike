<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Company();
        $data->name = 'Bike';
        $data->email = 'bike@gmail.com';
        $data->nit = '123456789';
        $data->phone = '123456789';
        $data->address = 'Kenedy';
        $data->user_id = 1; 
        $data->nameLegalRepresentative = 'Alejandro';
        $data->phoneLegalRepresentative = '123456789';
        $data->identification_rep = '123456789';
        $data->email_rep = 'bike@gmail.com';
        $data->address_rep = 'bogota';
        $data->logo = 'http://127.0.0.1:8000/storage/users/user_1/company/company_1/logo//izSJZkluX0AWBgMmdhX4XAmDcvJQRaB4NQ4XakJ8.png'; 
        $data->save();

        $data = new Company();
        $data->name = 'Yo Tramito';
        $data->email = 'yo_tramito@gmail.com';
        $data->nit = '123456789';
        $data->phone = '123456789';
        $data->address = 'Kenedy';
        $data->user_id = 1; 
        $data->nameLegalRepresentative = 'Alejandro';
        $data->phoneLegalRepresentative = '123456789';
        $data->identification_rep = '64555646546';
        $data->email_rep = 'bike@gmail.com';
        $data->address_rep = 'bogota';
        $data->logo = 'http://127.0.0.1:8000/storage/users/user_1/company/company_2/logo//izSJZkluX0AWBgMmdhX4XAmDcvJQRaB4NQ4XakJ8.png'; 
        $data->save();

        $data = new Company();
        $data->name = 'Su Service Taller';
        $data->email = 'su_service_taller@gmail.com';
        $data->nit = '123456789';
        $data->phone = '123456789';
        $data->address = 'Kenedy';
        $data->user_id = 1; 
        $data->nameLegalRepresentative = 'Alejandro';
        $data->phoneLegalRepresentative = '123456789';
        $data->identification_rep = '64555646546';
        $data->email_rep = 'bike@gmail.com';
        $data->address_rep = 'bogota';
        $data->logo = 'http://127.0.0.1:8000/storage/users/user_1/company/company_3/logo//izSJZkluX0AWBgMmdhX4XAmDcvJQRaB4NQ4XakJ8.png'; 
        $data->save();
    }
}
