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
                'title' => 'Empresas',
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
                'title' => 'Gastos',
                'to' => 'Admin-Third-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.third.index',
            ],
            [
                'id' => 5,
                'title' => 'Ingreso Vehiculos',
                'to' => 'Admin-Inventory-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.inventory.index',
            ],
            [
                'id' => 5,
                'title' => 'Ventas',
                'to' => 'Admin-Sales-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.sales.index',
            ],
            [
                'id' => 6,
                'title' => 'Administrativo',
                'to' => 'Admin-Administration-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.administration.index',
            ],
            [
                'id' => 7,
                'title' => 'Mecanicos',
                'to' => 'Admin-Mecanic-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.mecanic.index',
            ],
            [
                'id' => 8,
                'title' => 'Ingreso Vehiculo Taller',
                'to' => 'Admin-IncomeVehicle-Index',
                'icon' => 'mdi-arrow-right-thin-circle-outline',
                'requiredPermission' => 'admin.incomeVehicle.index',
            ]
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
