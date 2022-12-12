<?php

namespace App\Models\HRIS;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shift extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $primaryKey = 'shift_id';

    protected $fillable = [
        'company_id',
        'branch_id',
        'shift_type',
        'start_shift',
        'end_shift',
        'created_by',
        'created_by',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getAllShifts()
    {
        $query = "SELECT s.shift_id,s.company_id,s.shift_type,s.start_shift,s.end_shift,s.`status`,s.created_at,s.updated_at,
        CONCAT(cu.first_name,' ',cu.last_name) AS created_by, CONCAT(uu.first_name,' ',uu.last_name) AS updated_by
        FROM shifts s 
        JOIN companies c ON s.company_id=c.company_id
        JOIN branches b ON s.branch_id=b.branch_id";

        if (auth()->user()->company_id)
            $query .= " AND s.company_id=" . auth()->user()->company_id;

        $query .= " LEFT JOIN users cu ON s.created_by=cu.id
        LEFT JOIN users uu ON s.updated_by=uu.id";

        return DB::select($query);
    }

    public static function getShifts($company_id)
    {
        return self::where('company_id',$company_id)->where('status','Active')->get();
    }
}
