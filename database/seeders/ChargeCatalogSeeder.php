<?php

namespace Database\Seeders;

use App\Models\ChargeCatalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChargeCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            "Aprendiz Sena",
            "Auxiliar Administrativo",
            "Auxiliar Contable",
            "Auxiliar de Cartera",
            "Gerente Administrativo y Financiero",
            "Gerente General",
            "Jefe de Cartera",
            "Otros 82",
            "Recepcionista",
            "Secretaria",
            "Auxiliar de Servicios Generales",
            "Tesorero",
            "Analista Contable",
            "Auditor Interno",
            "Contador",
            "Director Administrativo",
            "Telemercadeo",
            "Diseñador Gráfico",
            "Asesor Comercial",
            "Coordinador Comercial",
            "Jefe de Ventas",
            "Gerente Comercial",
            "Jefe de Mercadeo",
            "Otros 83",
            "Otros 58",
            "Técnico 70",
            "Asesor Operativo",
            "Asesor de Servicio al Cliente",
            "Coordinador de Servicio al Cliente",
            "Jefe de Servicio al Cliente",
            "Gerente de Servicio al Cliente",
            "Coordinador de Recursos Humanos",
            "Asistente de Recursos Humanos",
            "Gerente de Recursos Humanos",
            "Otros 86",
            "Ingeniero",
            "Investigador",
            "Analista",
            "Ingeniero Especialista",
            "Jefe de Tecnología",
            "Gerente de Tecnología",
            "Técnico 84",
            "Otros 85",
        ];
        foreach ($arrayData as $key => $value) {
            $data = new ChargeCatalog(); 
            $data->name =  $value; 
            $data->save();
        }
    }
}
