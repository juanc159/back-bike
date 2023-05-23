<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $company = Company::first();
        $data = new Role();
        $data->name = 'Gerente_'.$company->id; 
        $data->description = 'Gerente'; 
        $data->company_id = $company->id;
        $data->save();
        $data->permissions()->sync([1,2,3,4]);
    }
}
