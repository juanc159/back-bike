<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       $company = Company::find(1);
       $company->user_id = 1;
       $company->save();

       $company = Company::find(2);
       $company->user_id = 1;
       $company->save();

       $company = Company::find(3);
       $company->user_id = 1;
       $company->save();

    }
}
