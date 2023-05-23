<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            "DAVIPLATA",
            "NEQUI",
            "RAPIIPAY",
            "TPAGA",
            "ABN AMRO BANK",
            "BANCAMIA",
            "BANCO AGRARIO DE COLOMBIA S.A",
            "BANCO AV VILLAS",
            "BANCO CAJA SOCIAL -BCSC S.A",
            "BANCO COOPERATIVO COOPCENTRAL",
            "BANCO CORBANCA COLOMBIA S.A",
            "BANCO DAVIVIENDA S.A ",
            "BANCO DE BOGOTÁ",
            "BANCO DE CREDITO",
            "BANCO DE LA REPÚBLICA",
            "BANCO DE OCCIDENTE",
            "BANCO FALABELLA S.A",
            "BANCO FINANDINA S.A",
            "BANCO GNB COLOMBIA S.A",
            "BANCO GNB SUDAMERIS COLOMBIA",
            "BANCO ITAU",
            "BANCO PICHINCHA S.A",
            "BANCO POPULAR",
            "BANCO PROCREDIT",
            "BANCO SANTANDER",
            "BANCO SERFINANZA",
            "BANCO UNIÓN",
            "BANCO WWB S.A",
            "BANCOLDEX",
            "BANCOLOMBIA S.A",
            "BANCOOMEVA",
            "BBVA COLOMBIA",
            "CITIBANK COLOMBIA",
            "COLPATRIA",
            "COLTEFINANCIERA",
            "CONFIAR COOPERATIVA FINANCIERA",
            "COPERATIVA FINANCIERA DE ANTIOQUIA",
            "COOTRAFA COOPERATIVA FINANCIERA",
            "CORFICOLOMBIANA",
            "CREDIFLORES COOPERATIVA DE AHORRO Y CRÉDITO",
            "DECEVAL",
            "FINANCIERA JURISCOOP COMPAÑÍA DE FINANCIAMIENTO",
            "GRANBANCO",
            "HELM BANK",
            "HSBC",
            "RED MULTIBANCA COLPATRIA S.A",
            "SKANDIA",
        ];

        foreach ($arrayData as $key => $value) {
            $data = new Bank(); 
            $data->name =  $value;
            $data->save();
        }
    }
}
