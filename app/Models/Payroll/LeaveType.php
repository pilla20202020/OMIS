<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'leave_type',
        'description',
        'status'
    ];

    public static function getAllLeaveTypes()
    {
        $query = "SELECT d.id,d.leave_type,d.days,d.`status`,d.created_at,d.updated_at,
        CONCAT(cu.first_name,' ',cu.last_name) AS created_by, CONCAT(uu.first_name,' ',uu.last_name) AS updated_by
        FROM leave_types d 
        JOIN companies c ON d.company_id=c.company_id";

        if (auth()->user()->company_id)
            $query .= " AND d.company_id=" . auth()->user()->company_id;

        $query .= " LEFT JOIN users cu ON d.created_by=cu.id
        LEFT JOIN users uu ON d.updated_by=uu.id";

        return DB::select($query);
    }
}
