<?php

namespace Database\Seeders;

use App\Models\HRIS\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            [
                'company_id' => 1,
                'branch_id' => 1,
                'dept_id' => 1,
                'designation_name' => 'BOD',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'dept_id' => 1,
                'designation_name' => 'CEO',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'dept_id' => 2,
                'designation_name' => 'Manager',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'dept_id' => 3,
                'designation_name' => 'Manager',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'dept_id' => 4,
                'designation_name' => 'Manager',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'dept_id' => 5,
                'designation_name' => 'Manager',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'dept_id' => 6,
                'designation_name' => 'Manager',
                'created_by' => 1,
                'updated_by' => 1
            ],
        ];

        foreach ($designations as $designation) {
            $isExistdesignation = Designation::where('designation_name', $designation['designation_name'])
                ->where('company_id', 1)->first();
            if (!$isExistdesignation)
                Designation::create($designation);
        }
    }
}
