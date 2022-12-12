<?php

namespace App\Helpers;

use App\Models\Company;
use App\Models\CompanyFeature;
use App\Models\HRIS\Branch;
use App\Models\HRIS\Department;
use App\Models\HRIS\Designation;
use App\Models\Permission;
use Exception;


class GeneralHelper
{
    protected $company;
    protected $branch;
    protected $department;
    protected $permission;
    protected $companyFeature;
    protected $designation;
    public function __construct()
    {
        $this->company = new Company();
        $this->branch = new Branch();
        $this->department = new Department();
        $this->designation = new Designation();
        $this->permission = new Permission();
        $this->companyFeature = new CompanyFeature();

    }

    public function getCompanies()
    {
        return $this->company->where('status', 'Active')->select('company_id', 'company_name')->get();
    }

    public function getBranches($company_id)
    {
        return $this->branch->where('company_id', $company_id)->where('status', 'Active')->select('branch_id', 'branch_name')->get();
    }

    public function getDepartments($company_id, $branch_id)
    {
        return $this->department->where('company_id', $company_id)->where('branch_id', $branch_id)->where('status', 'Active')->select('dept_id', 'department_name')->get();
    }

    public function getPermissionForRole()
    {
        $features = $this->companyFeature->where('company_id', auth()->user()->company_id)->pluck('feature_id')->toArray();
        return $this->permission->select('group_name')->whereIn('feature_id', $features)->where('group_name', '!=', 'Branch')
            ->where('group_name', '!=', 'Role')
            ->groupBy('group_name')->get()->chunk(3);
    }

    public function getDesignationByDeptId($dept_id)
    {
        return $this->designation->select('designation_id','designation_name')->where('dept_id',$dept_id)->get();
    }
}
