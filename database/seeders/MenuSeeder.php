<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            [
                'id' => 1,
                'title' => 'Mis Clientes',
                'to' => 'Admin-Company-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.company.index',
            ],
            [
                'id' => 2,
                'title' => 'Usuarios',
                'to' => 'Admin-User-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.user.index',
            ],

            [
                'id' => 3,
                'title' => 'Roles',
                'to' => 'Admin-Role-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.role.index',
            ],
            [
                'id' => 4,
                'title' => 'Terceros',
                'to' => 'Admin-Third-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.third.index',
            ],
            [
                'id' => 5,
                'title' => 'Inventario',
                'to' => 'Admin-Inventory-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.inventory.index',
            ],
            /*[
                "title" => "Menu",
                "to" => "Admin-Menu-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.menu.index"
            ],
            [
                "title" => "Permisos",
                "to" => "Admin-Permission-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.permission.index"
            ],  */
        ];
        foreach ($arrayData as $key => $value) {
            $data = new Menu();
            $data->title = $value['title'];
            $data->to = $value['to'];
            $data->icon = $value['icon'];
            $data->father = $value['father'] ?? null;
            $data->requiredPermission = $value['requiredPermission'];
            $data->save();
        }
    }
}
