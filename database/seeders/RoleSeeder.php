<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Role();
        $data->name = 'Administrador';
        $data->description = 'Administrador';
        $data->save();
        $data->permissions()->sync([1, 2, 3,4,5,6]);
    }
}
