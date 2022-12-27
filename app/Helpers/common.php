<?php

use App\Models\Company;
use App\Models\CompanyFeature;
use App\Models\HRIS\Branch;
use App\Models\HRIS\Department;
use App\Models\HRIS\Designation;
use App\Models\HRIS\Employee;
use App\Models\HRIS\Role;
use App\Models\HRIS\RoleUser;
use App\Models\HRIS\Shift;
use App\Models\Payroll\LeaveType;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;

function permission($permission)
{
    $user_id = auth()->user()->id;
    /** 
     * IF super Admin is logged as company then give only company full permission.
     * All the users are store in user table.
     */
    if (auth()->user()->user_type == 'SUPER ADMIN' && isset(auth()->user()->company_id)) {
        $companyUser = User::where('company_id', auth()->user()->company_id)->where('user_type', 'COMPANY')->firstOrFail();
        $userPermission = UserPermission::where('user_id', $companyUser->id)->first();
        $combinedPermissions = json_decode($userPermission->permissions, true);
    } else {
        $company_id = auth()->user()->company_id;
        // Because company may not have any role but accessing all the functionality resion company user has all the permissions in user_permissions table
        //That why I used only first() method that can return null.
        $role = RoleUser::where('user_id', $user_id)->where('company_id', $company_id)->first();
        $rolePermissions = [];
        if ($role) {
            $roles = Role::findOrFail($role->role_id);
            $rolePermissions = json_decode($roles->permission, true);
        }
        $userPermission = [];
        $isUserPermission = UserPermission::where('user_id', $user_id)->first();
        if ($isUserPermission)
            $userPermission = json_decode($isUserPermission->permissions, true);
        $combinedPermissions = array_merge($rolePermissions, $userPermission);
    }

    return in_array($permission, $combinedPermissions);
}


function getUserPermissions($userId)
{
    // $userPermission = UserPermission::where('user_id', $userId)->first();
    // return json_decode($userPermission->permissions, true);
    $user_id = auth()->user()->id;
    /** 
     * IF super Admin is logged as company then give only company full permission.
     * All the users are store in user table.
     */
    if (auth()->user()->user_type == 'SUPER ADMIN' && isset(auth()->user()->company_id)) {
        $companyUser = User::where('company_id', auth()->user()->company_id)->where('user_type', 'COMPANY')->firstOrFail();
        $userPermission = UserPermission::where('user_id', $companyUser->id)->first();
        $combinedPermissions = json_decode($userPermission->permissions, true);
    } else {
        $company_id = auth()->user()->company_id;
        // Because company may not have any role but accessing all the functionality resion company user has all the permissions in user_permissions table
        //That why I used only first() method that can return null.
        $role = RoleUser::where('user_id', $user_id)->where('company_id', $company_id)->first();
        $rolePermissions = [];
        if ($role) {
            $roles = Role::findOrFail($role->role_id);
            $rolePermissions = json_decode($roles->permission, true);
        }
        $userPermission = [];
        $isUserPermission = UserPermission::where('user_id', $user_id)->first();
        if ($isUserPermission)
            $userPermission = json_decode($isUserPermission->permissions, true);
        $combinedPermissions = array_merge($rolePermissions, $userPermission);
    }
    return $combinedPermissions;
}

function getCompanyPermissions()
{
    $features = CompanyFeature::where('company_id', auth()->user()->company_id)->pluck('feature_id')->toArray();
    return Permission::select('group_name')->whereIn('feature_id', $features)->groupBy('group_name')->get()->chunk(3);
}

function getDepartments($company_id)
{
    return Department::getDepartments($company_id);
}

function getDesignations($company_id)
{
    return Designation::getDesignations($company_id);
}

function getShifts($company_id)
{
    return Shift::getShifts($company_id);
}

function getRoles($company_id)
{
    return Role::getRoles($company_id);
}

function isSuperAdminLoggedAsCompany()
{
    $user = auth()->user();
    $company = Company::find($user->company_id);
    $companyName = $company ? $company->company_name : "";
    return $user->user_type . " Logged As  " . $companyName . ", Company";
}

// getting  user as branch information
function isLoggedAsBranch()
{
    $branch_id = auth()->user()->branch_id;
    $branch = Branch::find(auth()->user()->branch_id);
    return $branch ? auth()->user()->user_type . " Logged As " . $branch->branch_name . ", Branch" : "";
}

function getEmployees($company_id, $dept_id = null, $hift_id = null)
{
    $employees = Employee::where('company_id', $company_id);
    if ($dept_id)
        $employees->where('dept_id', $dept_id);

    if ($hift_id)
        $employees->where('shift_id', $hift_id);

    return $employees->get();
}

function getLeaveTypes($company_id)
{
    return LeaveType::where('company_id', $company_id)->get();
}

function getUserRoleByUserIdAndCompanyId($user_id, $company_id)
{
    return RoleUser::where('user_id', $user_id)->where('company_id', $company_id)->first();
}
