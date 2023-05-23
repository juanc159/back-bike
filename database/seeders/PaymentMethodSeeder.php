<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
        [
            "id"=>1,
            "code"=>1,
            "name"=>"Instrumento no definido",
        ],
        [
            "id"=>2,
            "code"=>10,
            "name"=>"Efectivo",
        ],
        [
            "id"=>3,
            "code"=>11,
            "name"=>"Reversión Crédito Ahorro",
        ],
        [
            "id"=>4,
            "code"=>12,
            "name"=>"Reversión Débito Ahorro",
        ],
        [
            "id"=>5,
            "code"=>13,
            "name"=>"Crédito Ahorro",
        ],
        [
            "id"=>6,
            "code"=>14,
            "name"=>"Débito Ahorro",
        ],
        [
            "id"=>7,
            "code"=>15,
            "name"=>"Bookentry Crédito",
        ],
        [
            "id"=>8,
            "code"=>16,
            "name"=>"Bookentry Débito",
        ],
        [
            "id"=>9,
            "code"=>17,
            "name"=>"Desembolso Crédito (CCD)",
        ],
        [
            "id"=>10,
            "code"=>18,
            "name"=>"Desembolso (CCD) débito",
        ],
        [
            "id"=>11,
            "code"=>19,
            "name"=>"Crédito Pago megocio corporativo (CTP)",
        ],
        [
            "id"=>12,
            "code"=>2,
            "name"=>"Crédito ACH",
        ],
        [
            "id"=>13,
            "code"=>20,
            "name"=>"Cheque",
        ],
        [
            "id"=>14,
            "code"=>21,
            "name"=>"Proyecto bancario",
        ],
        [
            "id"=>15,
            "code"=>22,
            "name"=>"Proyecto bancario certificado",
        ],
        [
            "id"=>16,
            "code"=>23,
            "name"=>"Cheque bancario certificado",
        ],
        [
            "id"=>17,
            "code"=>24,
            "name"=>"Nota cambiaria esperando aceptación",
        ],
        [
            "id"=>18,
            "code"=>25,
            "name"=>"Cheque certificado",
        ],
        [
            "id"=>19,
            "code"=>26,
            "name"=>"Cheque Local",
        ],
        [
            "id"=>20,
            "code"=>27,
            "name"=>"Débito Pago Negocio Corporativo (CTP)",
        ],
        [
            "id"=>21,
            "code"=>28,
            "name"=>"Crédito Negocio Intercambio Corporativo (CTX)",
        ],
        [
            "id"=>22,
            "code"=>29,
            "name"=>"Débito Negocio Intercambio Corporativo (CTX)",
        ],
        [
            "id"=>23,
            "code"=>3,
            "name"=>"Débito ACH",
        ],
        [
            "id"=>24,
            "code"=>30,
            "name"=>"Transferencia Crédito",
        ],
        [
            "id"=>25,
            "code"=>31,
            "name"=>"Transferencia Débito",
        ],
        [
            "id"=>26,
            "code"=>32,
            "name"=>"Desembolso Crédito plus (CCD+)",
        ],
        [
            "id"=>27,
            "code"=>33,
            "name"=>"Desembolso Débito plus (CCD+)",
        ],
        [
            "id"=>28,
            "code"=>34,
            "name"=>"Pago y depósito pre acordado (PPD)",
        ],
        [
            "id"=>29,
            "code"=>35,
            "name"=>"Desembolso Crédito (CCD)",
        ],
        [
            "id"=>30,
            "code"=>36,
            "name"=>"Desembolso Débito (CCD)",
        ],
        [
            "id"=>31,
            "code"=>37,
            "name"=>"Pago Negocio Corporativo Ahorros Crédito (CTP)",
        ],
        [
            "id"=>32,
            "code"=>38,
            "name"=>"Pago Negocio Corporativo Ahorros débito (CTP)",
        ],
        [
            "id"=>33,
            "code"=>39,
            "name"=>"Crédito Intercambio Corporativo (CTX)",
        ],
        [
            "id"=>34,
            "code"=>4,
            "name"=>"Revisión débito de demanda ACH",
        ],
        [
            "id"=>35,
            "code"=>40,
            "name"=>"Débito intercambio Corporativo (CTX)",
        ],
        [
            "id"=>36,
            "code"=>41,
            "name"=>"Desembolso Crédito plus(CCD+)",
        ],
        [
            "id"=>37,
            "code"=>42,
            "name"=>"Consignación bacaria",
        ],
        [
            "id"=>38,
            "code"=>43,
            "name"=>"Desembolso Débito plus (CCD+)",
        ],
        [
            "id"=>39,
            "code"=>44,
            "name"=>"Nota cambiaria",
        ],
        [
            "id"=>40,
            "code"=>45,
            "name"=>"Transferencia Crédito Bancario",
        ],
        [
            "id"=>41,
            "code"=>46,
            "name"=>"Transferencia Débito Interbancario",
        ],
        [
            "id"=>42,
            "code"=>47,
            "name"=>"Transferencia Débito Bancaria",
        ],
        [
            "id"=>43,
            "code"=>48,
            "name"=>"Tarjeta Crédito",
        ],
        [
            "id"=>44,
            "code"=>49,
            "name"=>"Tarjeta Débito",
        ],
        [
            "id"=>45,
            "code"=>5,
            "name"=>"Reversión Crédito de demanda ACH",
        ],
        [
            "id"=>46,
            "code"=>50,
            "name"=>"Postgiro",
        ],
        [
            "id"=>47,
            "code"=>51,
            "name"=>"Telex estándar bancario",
        ],
        [
            "id"=>48,
            "code"=>52,
            "name"=>"Pago comercial urgente",
        ],
        [
            "id"=>49,
            "code"=>53,
            "name"=>"Pago Tesorería Urgente",
        ],
        [
            "id"=>50,
            "code"=>6,
            "name"=>"Crédito de demanda ACH",
        ],
        [
            "id"=>51,
            "code"=>60,
            "name"=>"Nota promisoria",
        ],
        [
            "id"=>52,
            "code"=>61,
            "name"=>"Nota promisoria firmada por el acreedor",
        ],
        [
            "id"=>53,
            "code"=>62,
            "name"=>"Nota promisoria firmada por el acreedor, avalada por el banco",
        ],
        [
            "id"=>54,
            "code"=>63,
            "name"=>"Nota promisoria firmada por el acreedor, avalada por un tercero",
        ],
        [
            "id"=>55,
            "code"=>64,
            "name"=>"Nota promisoria firmada por el banco",
        ],
        [
            "id"=>56,
            "code"=>65,
            "name"=>"Nota promisoria firmada por un banco avalada por otro banco",
        ],
        [
            "id"=>57,
            "code"=>66,
            "name"=>"Nota promisoria firmada",
        ],
        [
            "id"=>58,
            "code"=>67,
            "name"=>"Nota promisoria firmada por un tercero avalada por un banco",
        ],
        [
            "id"=>59,
            "code"=>7,
            "name"=>"Débito de demanda ACH",
        ],
        [
            "id"=>60,
            "code"=>70,
            "name"=>"Retiro de nota por el acreedor",
        ],
        [
            "id"=>61,
            "code"=>71,
            "name"=>"Bonos",
        ],
        [
            "id"=>62,
            "code"=>72,
            "name"=>"Vales",
        ],
        [
            "id"=>63,
            "code"=>74,
            "name"=>"Retiro de nota por el acreedor sobre un banco",
        ],
        [
            "id"=>64,
            "code"=>75,
            "name"=>"Retiro de nota por el acreedor, avalada por otro un banco",
        ],
        [
            "id"=>65,
            "code"=>76,
            "name"=>"Retiro de nota por el acreedor, sobre un banco avalada por un tercero",
        ],
        [
            "id"=>66,
            "code"=>77,
            "name"=>"Retiro de nota por el acreedor sobre un tercero",
        ],
        [
            "id"=>67,
            "code"=>78,
            "name"=>"Retiro de nota por el acreedor sobre un tercero avalada opr un banco",
        ],
        [
            "id"=>68,
            "code"=>9,
            "name"=>"Clearing Nacional o regional",
        ],
        [
            "id"=>69,
            "code"=>91,
            "name"=>"Nota bancaria transferible",
        ],
        [
            "id"=>70,
            "code"=>92,
            "name"=>"Cheque local transferible",
        ],
        [
            "id"=>71,
            "code"=>93,
            "name"=>"Giro referenciado",
        ],
        [
            "id"=>72,
            "code"=>94,
            "name"=>"Giro urgente",
        ],
        [
            "id"=>73,
            "code"=>95,
            "name"=>"Giro formato abierto",
        ],
        [
            "id"=>74,
            "code"=>96,
            "name"=>"Método de pago solicitado no usuado",
        ],
        [
            "id"=>75,
            "code"=>97,
            "name"=>"Clearing entre partners",
        ],
        [
            "id"=>76,
            "code"=>98,
            "name"=>"Otro",
        ],
        [
            "id"=>77,
            "code"=>99,
            "name"=>"Trámite simple (Recarga o envío)",
        ],
        [
            "id"=>78,
            "code"=>100,
            "name"=>"Transferencia bancaria",
        ],
    ];
    foreach ($arrayData as $key => $value) {
        $data = new PaymentMethod();
        $data->id =  $value["id"];
        $data->code =  $value["code"];
        $data->name =  $value["name"];
        $data->save();
    }
    }
}
