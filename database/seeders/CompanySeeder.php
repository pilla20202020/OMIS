<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyFeature;
use App\Models\CompanyPermission;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'company_name' => 'CompanyFirst',
                'company_email' => 'companyfirst@test.test',
                'company_phone' => '01 67894567',
                'company_mobile' => 9816836470,
                'company_address' => 'kathmandu',
                'created_by' => 1,
                'updated_by' => 1
            ],

        ];


        foreach ($companies as $company) {
            $isExistCompany = Company::where('company_email', $company['company_email'])->first();
            if (!$isExistCompany) {
                $CreatedCompany = Company::create($company);
                $companyUserDetail = [
                    'first_name' => 'User',
                    'last_name' => 'Owner',
                    'mobile' => '9811111111',
                    'email' => 'user@firstcompany.com',
                    'user_type' => 'COMPANY',
                    'company_id' => $CreatedCompany->company_id,
                    'password' => Hash::make('password'),
                    'created_by' => 1,
                    'updated_by' => 1
                ];
                $user = User::create($companyUserDetail);
                $featureIds = [2, 3, 4];
                foreach ($featureIds as $id) {
                    CompanyFeature::create(['company_id' => $CreatedCompany->company_id, 'feature_id' => $id, 'created_by' => 1, 'updated_by' => 1]);
                }
                $permissions = Permission::select('name')->whereIn('feature_id', $featureIds)->get();
                foreach ($permissions as $permission)
                    $allCompanyPermission[] = $permission->name;
                CompanyPermission::create(['company_id' => $CreatedCompany->company_id, 'permission' => json_encode($allCompanyPermission), 'created_by' => 1, 'updated_by' => 1]);
                UserPermission::create(['user_id' => $user->id, 'permissions' => json_encode($allCompanyPermission), 'created_by' => 1, 'updated_by' => 1]);
            }
        }
    }
}
