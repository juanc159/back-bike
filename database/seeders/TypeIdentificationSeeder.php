<?php

namespace Database\Seeders;

use App\Models\TypeIdentification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeIdentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData=[
            [
                "id"=>1,
                "name"=>'Registro civil'
            ],
            [
                "id"=>2,
                "name"=>'Tarjeta de identidad'
            ],
            [
                "id"=>3,
                "name"=>'Cédula de ciudadanía'
            ],
            [
                "id"=>4,
                "name"=>'Tarjeta de extranjería'
            ],
            [
                "id"=>5,
                "name"=>'Cédula de extranjería'
            ],
            [
                "id"=>6,
                "name"=>'NIT'
            ],
            [
                "id"=>7,
                "name"=>'Pasaporte'
            ],
            [
                "id"=>8,
                "name"=>'Documento de identificación extranjero'
            ],
            [
                "id"=>9,
                "name"=>'NUIP'
            ],
            [
                "id"=>10,
                "name"=>'No obligado a registrarse en el RUT PN'
            ],
            [
                "id"=>11,
                "name"=>'Permiso especial de permanencia PEP'
            ],
            [
                "id"=>12,
                "name"=>'Sin identificación del exterior o para uso definido por la DIAN'
            ],
            [
                "id"=>13,
                "name"=>'Nit de otro país / Sin identificación del exterior (43 medios magnéticos)'
            ],
            [
                "id"=>14,
                "name"=>'salvaconducto de permanencia'
            ],
        ];

        foreach ($arrayData as $key => $value) {
            $data = new TypeIdentification();
            $data->id =  $value["id"];
            $data->name =  $value["name"];
            $data->save();
        }
    }
}
