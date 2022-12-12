<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    use HasFactory,CreatedUpdatedBy;

    protected $primaryKey = 'permission_id';

    protected $fillable = [
        'name',
        'showing_name',
        'guard_name',
        'group_name',
        'feature_id',
        'is_default',
        'related_to',
        'description',
        'created_by',
        'created_by',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public static function getAllpermissionDataList()
    {
        $query = "SELECT p.permission_id,p.name,p.showing_name,p.guard_name,p.group_name,p.description,case when p.is_default=1 then 'YES' ELSE 'NO' END AS is_default,p.related_to,
        f.feature_name,CONCAT(cu.first_name,' ',cu.last_name) AS created_by,CONCAT(uu.first_name,' ',uu.last_name) AS updated_by,p.`status`,p.created_at,p.updated_at
        FROM permissions p
        LEFT JOIN features f ON f.feature_id=p.feature_id
        JOIN users cu ON p.created_by=cu.id
        JOIN users uu ON p.updated_by=uu.id";
        return DB::select($query);
    }
}
