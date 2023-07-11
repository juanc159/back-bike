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
        $data->id = 1;
        $data->name = 'Super Administrador';
        $data->description = 'Super Administrador';
        $data->save();
        $data->permissions()->sync([1, 2, 3, 4, 5, 6, 7]);

        $data = new Role();
        $data->id = 2;
        $data->name = 'Administrador Bikers';
        $data->description = 'Administrador Bikers';
        $data->save();
        $data->permissions()->sync([2, 3, 4, 5, 6, 7]);

        $data = new Role();
        $data->id = 3;
        $data->name = 'Administrador Yo Tramito';
        $data->description = 'Administrador Yo Tramito';
        $data->save();
        $data->permissions()->sync([2, 3]);

        $data = new Role();
        $data->id = 4;
        $data->name = 'Administrador Su Service Taller';
        $data->description = 'Administrador Su Service Taller';
        $data->save();
        $data->permissions()->sync([2, 3, 4, 7, 8, 9]);
    }
}
