<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * -----------------------------------------------------------------------------
         * For simplicity For permission has index
         */
        $permissions =  [
            // config dashboard
            [
                "name" => "dashboard.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "Dashboard",
                "feature_id" => "2",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],

            // config feature
            [
                "name" => "config.feature.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "Feature",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // [
            //     "name" => "config.feature.list",
            //     "showing_name" => "List",
            //     "guard_name" => "WEB",
            //     "group_name" => "Feature",
            //     "feature_id" => "1",
            //     "is_default" => "YES",
            //     "related_to" => 'config.feature.view',
            //     "created_by" => "1",
            //     "updated_by" => "1"
            // ],
            [
                "name" => "config.feature.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "Feature",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "config.feature.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "Feature",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "config.feature.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "Feature",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],

            // config For Super Admin User
            [
                "name" => "config.user.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "For Super Admin User",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "config.user.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "For Super Admin User",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "config.user.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "For Super Admin User",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "config.user.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "For Super Admin User",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],

            // config company
            [
                "name" => "config.company.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "Company",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "config.company.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "Company",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "config.company.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "Company",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "config.company.show",
                "showing_name" => "Show",
                "guard_name" => "WEB",
                "group_name" => "Company",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "config.company.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "Company",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "config.company.login",
                "showing_name" => "Login As Company",
                "guard_name" => "WEB",
                "group_name" => "Company",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],

            // config Permission
            [
                "name" => "config.permission.SuperAdmin",
                "showing_name" => "IS SUPER ADMIN",
                "guard_name" => "WEB",
                "group_name" => "Permission",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "config.permission.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "Permission",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "config.permission.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "Permission",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "config.permission.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "Permission",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "config.permission.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "Permission",
                "feature_id" => "1",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // end config permission

            // HRIS department
            [
                "name" => "hris.department.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "department",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "hris.department.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "department",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "hris.department.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "department",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "hris.department.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "department",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // End of HRIS department

             // HRIS branch
             [
                "name" => "hris.branch.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "branch",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "hris.branch.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "branch",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "hris.branch.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "branch",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "hris.branch.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "branch",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // End of HRIS branch

            // HRIS designation
            [
                "name" => "hris.designation.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "designation",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "hris.designation.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "designation",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "hris.designation.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "designation",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "hris.designation.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "designation",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // End of HRIS designation

            // HRIS shift
            [
                "name" => "hris.shift.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "shift",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "hris.shift.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "shift",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "hris.shift.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "shift",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "hris.shift.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "shift",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // End of HRIS shift

            // HRIS employee
            [
                "name" => "hris.employee.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "employee",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "hris.employee.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "employee",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "hris.employee.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "employee",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "hris.employee.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "employee",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // End of HRIS employee

            // HRIS role
            [
                "name" => "hris.role.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "role",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "hris.role.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "role",
                "feature_id" => "3",
                "is_default" => "YES",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "hris.role.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "role",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "hris.role.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "role",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // End of HRIS role

             // HRIS user
             [
                "name" => "hris.user.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "user",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "hris.user.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "user",
                "feature_id" => "3",
                "is_default" => "YES",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "hris.user.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "user",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "hris.user.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "user",
                "feature_id" => "3",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            [
                "name" => "hris.user.permission",
                "showing_name" => "Permission",
                "guard_name" => "WEB",
                "group_name" => "user",
                "feature_id" => "3",
                "is_default" => "NO",
                "description" => "For Edit or create user Custom Permissions which are not present in the role",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // End of HRIS user

            // Payroll attendance
            [
                "name" => "payroll.attendance.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "attendance",
                "feature_id" => "4",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "payroll.attendance.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "attendance",
                "feature_id" => "4",
                "is_default" => "NO",
                "related_to" => 'NULL',
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "payroll.attendance.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "attendance",
                "feature_id" => "4",
                "is_default" => "NO",
                "related_to" => null,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "payroll.attendance.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "attendance",
                "feature_id" => "4",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],

            [
                "name" => "payroll.attendance.report.view",
                "showing_name" => "Attendance Report View",
                "guard_name" => "WEB",
                "group_name" => "attendance",
                "feature_id" => "4",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // End of HRIS attendance

             // Payroll leave-type
             [
                "name" => "payroll.leave-type.view",
                "showing_name" => "View",
                "guard_name" => "WEB",
                "group_name" => "leave type",
                "feature_id" => "4",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
           
            [
                "name" => "payroll.leave-type.create",
                "showing_name" => "Create",
                "guard_name" => "WEB",
                "group_name" => "leave type",
                "feature_id" => "4",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "payroll.leave-type.edit",
                "showing_name" => "Edit",
                "guard_name" => "WEB",
                "group_name" => "leave type",
                "feature_id" => "4",
                "is_default" => "NO",
                "related_to" => NUll,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            
            [
                "name" => "payroll.leave-type.delete",
                "showing_name" => "Delete",
                "guard_name" => "WEB",
                "group_name" => "leave type",
                "feature_id" => "4",
                "is_default" => "NO",
                "related_to" => NULL,
                "created_by" => "1",
                "updated_by" => "1"
            ],
            // End of HRIS user
        ];

        foreach ($permissions as $permission) {
            $existedPErmission = Permission::where('name',$permission['name'])->first();
            if(!$existedPErmission)
                Permission::create($permission);
        }

        // Foir super admin set all the permission means updated permissions also.
        $permissions = Permission::all();
        $userPermissions = [];
        foreach($permissions as $permission){
            $userPermissions[]= $permission->name;
        }

        $userPermissions = json_encode($userPermissions);
        // $userPermission = UserPermission::where('user_id',1)->firstOrFail();
        // $userPermission->update(['permissions'=>$userPermissions,'created_by'=>1,'updated_by'=>1]);
        // $userPermission->permissions = $userPermissions;
        // $userPermission->created_by = 1;
        // $userPermission->updated_by = 1;
        // $userPermission->save();
        DB::table('user_permissions')
        ->where('user_id', 1)  // find your user by their email
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array('permissions' => $userPermissions));
    }
}
