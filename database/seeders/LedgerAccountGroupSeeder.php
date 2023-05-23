<?php

namespace Database\Seeders;

use App\Models\LedgerAccountGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LedgerAccountGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "ledgerAccountClass_id"=>1,
                "code"=>11,
                "name"=>"Efectivo y equivalente de efectivo",
            ],
            [
                "id"=>2,
                "ledgerAccountClass_id"=>1,
                "code"=>12,
                "name"=>"Inversiones en asiciadas",
            ],
            [
                "id"=>3,
                "ledgerAccountClass_id"=>1,
                "code"=>13,
                "name"=>"Deudores comerciales y otras cuentas por cobrar",
            ],
            [
                "id"=>4,
                "ledgerAccountClass_id"=>1,
                "code"=>14,
                "name"=>"Inventarios",
            ],
            [
                "id"=>5,
                "ledgerAccountClass_id"=>1,
                "code"=>15,
                "name"=>"Propiedad planta y equipo",
            ],
            [
                "id"=>6,
                "ledgerAccountClass_id"=>1,
                "code"=>16,
                "name"=>"Intangibles",
            ],
            [
                "id"=>7,
                "ledgerAccountClass_id"=>1,
                "code"=>17,
                "name"=>"Otros activos no financieros",
            ],
            [
                "id"=>8,
                "ledgerAccountClass_id"=>1,
                "code"=>18,
                "name"=>"Impuesto a las ganancias",
            ],
            [
                "id"=>9,
                "ledgerAccountClass_id"=>1,
                "code"=>19,
                "name"=>"Otros activos financieros",
            ],
            [
                "id"=>10,
                "ledgerAccountClass_id"=>2,
                "code"=>21,
                "name"=>"Pasivos financieros",
            ],
            [
                "id"=>11,
                "ledgerAccountClass_id"=>2,
                "code"=>22,
                "name"=>"Proveedores",
            ],
            [
                "id"=>12,
                "ledgerAccountClass_id"=>2,
                "code"=>23,
                "name"=>"Acreedores comerciales y otras cuentas por pagar",
            ],
            [
                "id"=>13,
                "ledgerAccountClass_id"=>2,
                "code"=>24,
                "name"=>"Pasivos por impuestos",
            ],
            [
                "id"=>14,
                "ledgerAccountClass_id"=>2,
                "code"=>25,
                "name"=>"Beneficios a empleados",
            ],
            [
                "id"=>15,
                "ledgerAccountClass_id"=>2,
                "code"=>28,
                "name"=>"Pasivos no financieros",
            ],
            [
                "id"=>16,
                "ledgerAccountClass_id"=>3,
                "code"=>31,
                "name"=>"Capital social",
            ],
            [
                "id"=>17,
                "ledgerAccountClass_id"=>3,
                "code"=>32,
                "name"=>"Superávit de capital",
            ],
            [
                "id"=>18,
                "ledgerAccountClass_id"=>3,
                "code"=>33,
                "name"=>"Reservas",
            ],
            [
                "id"=>19,
                "ledgerAccountClass_id"=>3,
                "code"=>36,
                "name"=>"Resultado del ejercicio",
            ],
            [
                "id"=>20,
                "ledgerAccountClass_id"=>3,
                "code"=>37,
                "name"=>"Resultados de ejercicios anteriores",
            ],
            [
                "id"=>21,
                "ledgerAccountClass_id"=>3,
                "code"=>39,
                "name"=>"Afectaciones fiscales de ingresos y gastos",
            ],
            [
                "id"=>22,
                "ledgerAccountClass_id"=>4,
                "code"=>41,
                "name"=>"Ingresos de acividades ordinarias",
            ],
            [
                "id"=>23,
                "ledgerAccountClass_id"=>4,
                "code"=>42,
                "name"=>"Otros ingresos de actividades ordinarias",
            ],
            [
                "id"=>24,
                "ledgerAccountClass_id"=>4,
                "code"=>43,
                "name"=>"Ganancias",
            ],
            [
                "id"=>25,
                "ledgerAccountClass_id"=>4,
                "code"=>44,
                "name"=>"Ingresos fiscales",
            ],
            [
                "id"=>26,
                "ledgerAccountClass_id"=>5,
                "code"=>51,
                "name"=>"Administrativos",
            ],
            [
                "id"=>27,
                "ledgerAccountClass_id"=>5,
                "code"=>52,
                "name"=>"Ventas",
            ],
            [
                "id"=>28,
                "ledgerAccountClass_id"=>5,
                "code"=>53,
                "name"=>"Otros gastos de actividades ordinarias",
            ],
            [
                "id"=>29,
                "ledgerAccountClass_id"=>5,
                "code"=>54,
                "name"=>"Impuesto de renta y complementarios",
            ],
            [
                "id"=>30,
                "ledgerAccountClass_id"=>6,
                "code"=>61,
                "name"=>"Costo de ventas y de prestación de servicios",
            ],
            [
                "id"=>31,
                "ledgerAccountClass_id"=>7,
                "code"=>71,
                "name"=>"Costos de producción o de operación",
            ],
            [
                "id"=>32,
                "ledgerAccountClass_id"=>7,
                "code"=>72,
                "name"=>"Mano de obra directa",
            ],
            [
                "id"=>33,
                "ledgerAccountClass_id"=>7,
                "code"=>73,
                "name"=>"Costos indirectos",
            ],
            [
                "id"=>34,
                "ledgerAccountClass_id"=>7,
                "code"=>74,
                "name"=>"Contratos de servicios",
            ],
            [
                "id"=>35,
                "ledgerAccountClass_id"=>8,
                "code"=>81,
                "name"=>"Derechos contingentes",
            ],
            [
                "id"=>36,
                "ledgerAccountClass_id"=>9,
                "code"=>99,
                "name"=>"Cuentas de orden acreedoras",
            ],           
              
        ];

        foreach ($arrayData as $key => $value) {
            $data = new LedgerAccountGroup();
            $data->id =  $value["id"];
            $data->code =  $value["code"];
            $data->name =  $value["name"];
            $data->ledgerAccountClass_id =  $value["ledgerAccountClass_id"];
            $data->save();
        }
    }
}
