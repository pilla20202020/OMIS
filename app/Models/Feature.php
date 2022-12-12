<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Feature extends Model
{
    use HasFactory,CreatedUpdatedBy;

    protected $primaryKey = 'feature_id';

    protected $fillable = [
        'feature_name',
        'description',
        'created_by',
        'created_by',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public static function storeFeature($data)
    {
        return self::create($data);
    }
    public static function getAllFeaturesData()
    {
        $query = "SELECT f.feature_id,f.feature_name,f.description,CONCAT(cu.first_name,' ',cu.last_name) AS created_by,CONCAT(uu.first_name,' ',uu.last_name) AS 
        updated_by,f.`status`,f.created_at,f.updated_at
         FROM features f 
        JOIN users cu ON f.created_by=cu.id
        JOIN users uu ON f.updated_by=uu.id";

        return DB::select($query);
    }

    public static function getAllActiveFeatures()
    {
        return self::where('status','Active')->select('feature_id','feature_name')->get();
    }

}
