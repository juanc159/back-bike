<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PlanesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $data = new Role();
        $data->name = 'Contador'; 
        $data->description = 'Contador desde afuera';
        $data->save();
        $data->permissions()->sync([1,2,3,4,5,6,7,8]);
    }
}
