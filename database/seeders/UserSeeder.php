<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $role = Role::first();
        $data = new User();
        $data->name = 'Juan Carlos'; 
        $data->lastName = 'Moreno Guerra'; 
        $data->email = 'jcmg.ing@gmail.com'; 
        $data->password = Hash::make(159753123);
        $data->role_id = $role->id;
        $data->save();
        $data->roles()->sync($data->role_id);

        $role = Role::first();
        $data = new User();
        $data->name = 'Prueba'; 
        $data->lastName = 'Prueba'; 
        $data->email = 'prueba@gmail.com'; 
        $data->password = Hash::make('David2016');
        $data->role_id = $role->id;
        $data->save();
        $data->roles()->sync($data->role_id);
 
    }
}
