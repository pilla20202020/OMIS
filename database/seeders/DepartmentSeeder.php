<?php

namespace Database\Seeders;

use App\Models\HRIS\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'company_id' => 1,
                'branch_id' => 1,
                'department_name' => 'Head',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'department_name' => 'Admin',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'department_name' => 'Sales',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'department_name' => 'Finance',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'department_name' => 'HR',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'department_name' => 'Purchase',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'department_name' => 'Development',
                'created_by' => 1,
                'updated_by' => 1
            ],

        ];

        foreach ($departments as $department) {
            $isExistDepartment = Department::where('department_name', $department['department_name'])
                                    ->where('company_id',1)->first();
            if (!$isExistDepartment)
                Department::create($department);
        }
    }
}
