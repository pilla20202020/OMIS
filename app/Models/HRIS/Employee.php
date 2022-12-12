<?php

namespace App\Models\HRIS;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $primaryKey = 'emp_id';

    protected $fillable = [
        'user_id',
        'company_id',
        'branch_id',
        'dept_id',
        'designation_id',
        'shift_id',
        'first_name',
        'last_name',
        'mobile',
        'email',
        'address',
        'gender',
        'dob',
        'dob_nepali',
        'doj',
        'basic_salary',
        'travelling',
        'allowance',
        'is_CIT',
        'is_SSF',
        'is_EPF',
        'CIT',
        'SSF',
        'EPF',
        'created_by',
        'created_by',
        'status',
        'is_deleted',
        'is_login'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getAllEmployees()
    {
        $query = "SELECT e.emp_id,e.user_id,e.company_id,e.first_name,e.last_name,e.mobile,e.email,e.address,e.created_at,e.updated_at,e.`status`,e.is_deleted,d.department_name,ds.designation_name,
        s.shift_type,s.start_shift,s.end_shift,CONCAT(cu.first_name,' ',cu.last_name) AS created_by, CONCAT(uu.first_name,' ',uu.last_name) AS updated_by
        FROM employees e
        JOIN companies c ON e.company_id=c.company_id
        JOIN branches b ON e.branch_id=b.branch_id";

        if (auth()->user()->company_id)
            $query .= " AND e.company_id=" . auth()->user()->company_id;
        if (auth()->user()->branch_id)
            $query .= " AND e.branch_id=" . auth()->user()->branch_id;

        $query .= " JOIN departments d ON e.dept_id=d.dept_id
        JOIN	designations ds ON e.designation_id=ds.designation_id
        LEFT JOIN shifts s ON s.shift_id=e.shift_id
        LEFT JOIN users cu ON e.created_by=cu.id
        LEFT JOIN users uu ON e.updated_by=uu.id";

        return DB::select($query);
    }
}
