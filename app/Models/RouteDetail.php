<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Support\Facades\DB;

class RouteDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $primaryKey = 'route_id';

    protected $fillable = [
        'route_name',
        'show_route_name',
        'route_path',
        'method_name',
        'method_type',
        'controller_name',
        'group_name',
        'feature_id',
        'created_by',
        'created_by',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public static function storeRoute($data)
    {
        return self::updateOrCreate(['route_id', $data['route_id']],$data);
        
    }

    public static function getAllRoutesDataList()
    {
        $query = "SELECT r.route_id,r.route_name,r.show_route_name,r.route_path,r.method_name,r.method_type,r.controller_name,r.group_name,
        f.feature_name,CONCAT(cu.first_name,' ',cu.last_name) AS created_by, CONCAT(uu.first_name,' ',uu.last_name) AS updated_by,
        r.`status`,r.created_at,r.updated_at
        FROM route_details r
        JOIN features f ON r.feature_id=f.feature_id 
        JOIN users cu ON r.created_by=cu.id
        JOIN users uu ON r.updated_by=uu.id";

        return DB::select($query);
    }
}
