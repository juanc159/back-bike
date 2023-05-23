<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermissionTypesQuotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Permission();
        $data->id =  11;
        $data->name =  "admin.typesQuote.index";
        $data->description =  "Visualizar Tipo de Cotizaciones";
        $data->menu_id = 14;
        $data->save();

        $arrayData = [
            [
                "id" => 14,
                "title" => "Tipo de Cotizaciones",
                "to" => "Admin-TypesQuotes-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.typesQuote.index",
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
        $planContador->permissions()->attach([11]);
    }
}
