<?php

namespace App\Models\HRIS;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $primaryKey = 'role_id';

    protected $fillable = [
        'company_id',
        'role_name',
        'permission',
        'created_by',
        'created_by',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public static function getAllRoles()
    {
        $query = "SELECT r.role_id,r.company_id,r.role_name,r.`status`,r.created_at,r.updated_at,
        CONCAT(cu.first_name,' ',cu.last_name) AS created_by, CONCAT(uu.first_name,' ',uu.last_name) AS updated_by
        FROM roles r
        JOIN companies c ON r.company_id=c.company_id";

        if (auth()->user()->company_id)
            $query .= " AND r.company_id=" . auth()->user()->company_id;

        $query .= " LEFT JOIN users cu ON r.created_by=cu.id
        LEFT JOIN users uu ON r.updated_by=uu.id";

        return DB::select($query);
    }

    public static function getRoles($company_id)
    {
        return self::where('company_id', $company_id)->where('status', 'Active')->get();
    }
}
