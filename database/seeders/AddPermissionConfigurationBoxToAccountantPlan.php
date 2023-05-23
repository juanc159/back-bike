<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermissionConfigurationBoxToAccountantPlan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Permission();
        $data->id =  9;
        $data->name =  "admin.cashReceipt.index";
        $data->description =  "Visualizar Recibo de caja";
        $data->menu_id = 10;
        $data->save();

        $arrayData = [
            [
                "id" => 10,
                "title" => "Recibo de caja",
                "to" => "Admin-CashReceipt-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.cashReceipt.index",
                "father" => null,
            ],
            [
                "id" => 11,
                "title" => "Configuración",
                "to" => "Admin-CashReceiptConfiguration-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.cashReceipt.index",
                "father" => 10,
            ],
            [
                "id" => 12,
                "title" => "Listado",
                "to" => "Admin-CashReceipt-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.cashReceipt.index",
                "father" => 10,
            ],
        ];
        foreach ($arrayData as $key => $value) {
            $data = new Menu();
            $data->id =  $value["id"];
            $data->title =  $value["title"];
            $data->to =  $value["to"];
            $data->icon = $value["icon"];
            $data->father = $value["father"] ?? null;
            $data->requiredPermission = $value["requiredPermission"];
            $data->save();
        }


        $planContador = Role::find(1);
        $planContador->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    }
}
