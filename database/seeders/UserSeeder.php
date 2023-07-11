<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new User();
        $data->name = 'Super';
        $data->lastName = 'Administrador';
        $data->email = 'super-admin@gmail.com';
        $data->password = Hash::make(123456789);
        $data->role_id = 1;
        $data->save();
        $data->roles()->sync($data->role_id);

        $data = new User();
        $data->name = 'Admin';
        $data->lastName = 'Biker';
        $data->email = 'admin-biker@gmail.com';
        $data->password = Hash::make(123456789);
        $data->role_id = 2;
        $data->company_id = 1;
        $data->save();
        $data->roles()->sync($data->role_id);

        $data = new User();
        $data->name = 'Admin';
        $data->lastName = 'Yo Tramito';
        $data->email = 'admin-yo-tramito@gmail.com';
        $data->password = Hash::make(123456789);
        $data->role_id = 3;
        $data->company_id = 2;
        $data->save();
        $data->roles()->sync($data->role_id);

        $data = new User();
        $data->name = 'Admin';
        $data->lastName = 'Su Service Taller';
        $data->email = 'admin-su-service-taller@gmail.com';
        $data->password = Hash::make(123456789);
        $data->role_id = 4;
        $data->company_id = 3;
        $data->save();
        $data->roles()->sync($data->role_id);

    }
}
