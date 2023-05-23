<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermissionQuotes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Permission();
        $data->id =  10;
        $data->name =  "admin.quotes.index";
        $data->description =  "Visualizar Cotizaciones";
        $data->menu_id = 13;
        $data->save();

        $arrayData = [
            [
                "id" => 13,
                "title" => "Cotizaciones",
                "to" => "Admin-Quotes-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.quotes.index",
                "father" => 6,
            ]
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
        $planContador->permissions()->attach([10]);
    }
}
