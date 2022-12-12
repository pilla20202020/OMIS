<?php

namespace Database\Seeders;

use App\Models\HRIS\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'company_id' => 1,
                'role_name' => 'Super Admin',
                'permission' => [
                    "payroll.attendance.view",
                    "payroll.attendance.create",
                    "payroll.attendance.edit",
                    "payroll.attendance.delete",
                    "payroll.attendance.report.view",
                    "dashboard.view",
                    "hris.department.view",
                    "hris.department.create",
                    "hris.department.edit",
                    "hris.department.delete",
                    "hris.designation.view",
                    "hris.designation.create",
                    "hris.designation.edit",
                    "hris.designation.delete",
                    "hris.employee.view",
                    "hris.employee.create",
                    "hris.employee.edit",
                    "hris.employee.delete",
                    "payroll.leave-type.view",
                    "payroll.leave-type.create",
                    "payroll.leave-type.edit",
                    "payroll.leave-type.delete",
                    "hris.shift.view",
                    "hris.shift.create",
                    "hris.shift.edit",
                    "hris.shift.delete",
                    "hris.user.view",
                    "hris.user.edit",
                    "hris.user.delete",
                    "hris.user.permission"
                ],
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'role_name' => 'Admin',
                'permission' => [
                    "dashboard.view",
                    "hris.department.view",
                    "hris.department.create",
                    "hris.department.edit",
                    "hris.department.delete",
                    "hris.designation.view",
                    "hris.designation.create",
                    "hris.designation.edit",
                    "hris.designation.delete",
                    "hris.employee.view",
                    "hris.employee.create",
                    "hris.employee.edit",
                    "hris.employee.delete",
                    "payroll.leave-type.view",
                    "payroll.leave-type.create",
                    "payroll.leave-type.edit",
                    "payroll.leave-type.delete",
                    "hris.shift.view",
                    "hris.shift.create",
                    "hris.shift.edit",
                    "hris.shift.delete"
                ],
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'role_name' => 'Employee',
                'permission' => [
                    "payroll.attendance.view",
                    "dashboard.view",
                    "hris.department.view",
                    "hris.designation.view",
                    "hris.employee.view",
                    "payroll.leave-type.view",
                    "hris.shift.view",
                    "hris.user.view"
                ],
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'role_name' => 'Account',
                'permission' => [
                    "payroll.attendance.view",
                    "payroll.attendance.create",
                    "payroll.attendance.edit",
                    "payroll.attendance.delete",
                    "payroll.attendance.report.view",
                    "dashboard.view",
                    "hris.department.view",
                    "hris.designation.view",
                    "hris.employee.view",
                    "hris.employee.create",
                    "hris.employee.edit",
                    "hris.employee.delete",
                    "payroll.leave-type.view",
                    "hris.shift.view",
                    "hris.user.view"
                ],
                'created_by' => 1,
                'updated_by' => 1
            ],

        ];

        foreach ($roles as $role) {
            $role['permission'] = json_encode($role['permission']);
            $isExistrole = Role::where('role_name', $role['role_name'])
                ->where('company_id', 1)->first();
            if (!$isExistrole) {
                Role::create($role);
            } else {
                $isExistrole->update($role);
            }
        }
    }
}
