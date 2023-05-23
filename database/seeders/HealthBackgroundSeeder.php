<?php

namespace Database\Seeders;

use App\Models\HealthBackground;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthBackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            "A.I.C",
            "Aliansalud",
            "Ambuq Ars",
            "Anas Wayuu",
            "Ars Convida",
            "Asmet Salud",
            "Caja. Copi",
            "Capital Salud Eps",
            "Capresoca",
            "Ccf de la Guajira",
            "Ccf De Nariño ",
            "Cruz blanca Eps",
            "Empresas Públicas de Medellín Departamento Médico",
            "EPS Familiar de Colombia S.A.S",
            "Fondo de pasivo social de ferrocarriles de Colombia",
            "Fosyga Residente Exterior o Régimen Subsidiado",
            "Universidad de Córdoba",
            "Universidad Nacional de Colombia ",
            "Confacor ",
            "Confacundi ",
            "Comfamiliar Chocó",
            "Dusakawi",
            "Endisalud",
            "Comfamiliar Huila",
            "Comfaoriente",
            "Comfenalco Valle",
            "EPS Famisanar",
            "Fosyga",
            "Fosyga Régimen de Excepción",
            "Universidad de Cartagena",
            "Universidad Pedagógica- UPTC",
            "Pijaosalud",
            "Comparta",
            "Compensar",
            "Ecoopsos",
            "Coosalud",
            "Mutual Ser",
            "Sanitas",
            "Servicio Occidental de Salud",
            "Nueva Eps",
            "Saludvida",
            "Saludvida S.A EPS Movilidad",
            "Savia Salud"
        ];

        foreach ($arrayData as $key => $value) {
            $data = new HealthBackground(); 
            $data->name =  $value;
            $data->save();
        }
    }
}
