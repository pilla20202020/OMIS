<?php

namespace App\Models\HRIS;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $primaryKey = 'dept_id';

    protected $fillable = [
        'company_id',
        'branch_id',
        'department_name',
        'created_by',
        'created_by',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public static function getAllDepartments()
    {
        $query = "SELECT d.dept_id,d.department_name,d.`status`,d.created_at,d.updated_at,
        CONCAT(cu.first_name,' ',cu.last_name) AS created_by, CONCAT(uu.first_name,' ',uu.last_name) AS updated_by
        FROM departments d 
        JOIN companies c ON d.company_id=c.company_id
        JOIN branches b ON d.branch_id=b.branch_id";

        if(auth()->user()->company_id)
            $query .=" AND d.company_id=".auth()->user()->company_id;

        $query .=" LEFT JOIN users cu ON d.created_by=cu.id
        LEFT JOIN users uu ON d.updated_by=uu.id";
        
        return DB::select($query);
    }

    public static function getDepartments($company_id)
    {
        return self::where('company_id',$company_id)->where('status','Active')->get();
    }
}
