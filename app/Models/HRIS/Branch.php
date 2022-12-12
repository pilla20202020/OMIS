<?php

namespace App\Models\HRIS;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Branch extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $primaryKey = 'branch_id';

    protected $fillable = [
        'company_id',
        'branch_name',
        'branch_type',
        'contact_number',
        'mobile_number',
        'address',
        'description',
        'created_by',
        'created_by',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getAllBranches($company_id)
    {
        $query = "SELECT d.branch_id,d.branch_name,d.branch_type,d.`status`,d.created_at,d.updated_at,
        CONCAT(cu.first_name,' ',cu.last_name) AS created_by, CONCAT(uu.first_name,' ',uu.last_name) AS updated_by
        FROM branches d 
        JOIN companies c ON d.company_id=c.company_id";

        if (auth()->user()->company_id)
            $query .= " AND d.company_id=" . auth()->user()->company_id;
        if (isset($company_id))
            $query .= " AND d.company_id=" . $company_id;


        $query .= " LEFT JOIN users cu ON d.created_by=cu.id
        LEFT JOIN users uu ON d.updated_by=uu.id";

        return DB::select($query);
    }
}
