<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                'id' => 1,
                'name' => 'admin.company.index',
                'description' => 'Visualizar compañias',
                'menu_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'admin.user.index',
                'description' => 'Visualizar usuarios',
                'menu_id' => 2,
            ],

            [
                'id' => 3,
                'name' => 'admin.role.index',
                'description' => 'Visualizar roles',
                'menu_id' => 3,
            ],
            /*[
                "name" => "admin.menu.index",
                "description" => "Visualizar menu",
                "menu_id" => 2,
            ],
            [
                "name" => "admin.permission.index",
                "description" => "Visualizar permisos",
                "menu_id" => 4,
            ],
            [
                "name" => "admin.company.index",
                "description" => "Visualizar compañia",
                "menu_id" => 5,
            ],*/
        ];
        foreach ($arrayData as $key => $value) {
            $data = new Permission();
            $data->name = $value['name'];
            $data->description = $value['description'];
            $data->menu_id = $value['menu_id'];
            $data->save();
        }
    }
}
