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
            [
                'id' => 4,
                'name' => 'admin.third.index',
                'description' => 'Visualizar Terceros',
                'menu_id' => 4,
            ],
            [
                'id' => 5,
                'name' => 'admin.inventory.index',
                'description' => 'Visualizar Inventario',
                'menu_id' => 5,
            ],
            [
                'id' => 6,
                'name' => 'admin.sales.index',
                'description' => 'Visualizar Ventas',
                'menu_id' => 6,
            ],
            [
                "id" => 7,
                "name" => "admin.administration.index",
                "description" => "Visualizar Administrativo",
                "menu_id" => 7,
            ],
            [
                "id" => 8,
                "name" => "admin.mecanic.index",
                "description" => "Visualizar Mecanicos",
                "menu_id" => 8,
            ],
            [
                "id" => 9,
                "name" => "admin.incomeVehicle.index",
                "description" => "Ingreso Vehiculos",
                "menu_id" => 9,
            ],
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
