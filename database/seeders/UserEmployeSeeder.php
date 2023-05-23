<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserEmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $data = new User();
        $data->name = 'Juan Carlos'; 
        $data->lastName = 'Moreno'; 
        $data->email = 'juan@gmail.com'; 
        $data->password = Hash::make('David2016');
        $data->role_id = 2;
        $data->company_id = 1;
        $data->save();
        $data->roles()->sync($data->role_id);
    }
}
