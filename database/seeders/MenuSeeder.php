<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                "id" => 1,
                "title" => "Mis Clientes",
                "to" => "Admin-Company-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.company.index"
            ],
            [
                "id" => 2,
                "title" => "Usuarios",
                "to" => "Admin-User-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.user.index"
            ],

            [
                "id" => 3,
                "title" => "Roles",
                "to" => "Admin-Role-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.role.index"
            ],
            [
                "id" => 4,
                "title" => "Cuentas Contables",
                "to" => "Admin-LedgerAccount-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.ledgerAccount.index"
            ],
            [
                "id" => 5,
                "title" => "Catálogo de cargo",
                "to" => "Admin-ChargeCatalog-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.chargeCatalog.index"
            ],
            [
                "id" => 6,
                "title" => "Facturación",
                "to" => "Admin-Invoice-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.invoice.index",
            ], 
            [
                "id" => 7,
                "title" => "Configuración Factura",
                "to" => "Admin-TypesReceiptInvoice-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.typesReceiptInvoice.index",
                "father" => 6,
            ],
            [
                "id" => 8,
                "title" => "Listado Faturación",
                "to" => "Admin-Invoice-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.invoice.index",
                "father" => 6,
            ], 
            [
                "id" => 9,
                "title" => "Listado Productos",
                "to" => "Admin-Product-Index",
                "icon" => "mdi-arrow-right-thin-circle-outline",
                "requiredPermission" => "admin.product.index",
                "father" => 6,
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
            $data->title =  $value["title"];
            $data->to =  $value["to"];
            $data->icon = $value["icon"];
            $data->father = $value["father"] ?? null;
            $data->requiredPermission = $value["requiredPermission"];
            $data->save();
        }
    }
}
