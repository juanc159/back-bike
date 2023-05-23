<?php

namespace Database\Seeders;

use App\Models\FormatDisplayPrintInvoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormatDisplayPrintInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Básico Media Carta'
            ],
            [
                "id"=>2,
                "name"=>'Básico'
            ],
            [
                "id"=>3,
                "name"=>'Básico Página completa'
            ],
            [
                "id"=>4,
                "name"=>'Básico Página completa con periodo'
            ],
            [
                "id"=>5,
                "name"=>'Básico mejorado (Nuevo)'
            ],
            [
                "id"=>6,
                "name"=>'Cuenta de cobro 1'
            ],
            [
                "id"=>7,
                "name"=>'Cuenta de cobro 2'
            ],
            [
                "id"=>8,
                "name"=>'ERPDocinvoiceBasic2HalfLetterPDF'
            ],
            [
                "id"=>9,
                "name"=>'ERPDocinvoiceBasicHalfLetterPDF'
            ],
            [
                "id"=>10,
                "name"=>'Elegante'
            ],
            [
                "id"=>11,
                "name"=>'Espontáneo'
            ],
            [
                "id"=>12,
                "name"=>'Exportación'
            ],
            [
                "id"=>13,
                "name"=>'Fresco'
            ],
            [
                "id"=>14,
                "name"=>'Halft Letter Basic 2'
            ],
            [
                "id"=>15,
                "name"=>'Simétrico'
            ],
            [
                "id"=>16,
                "name"=>'Tirilla'
            ],
            [
                "id"=>17,
                "name"=>'Tirilla Especifica'
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new FormatDisplayPrintInvoice();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
