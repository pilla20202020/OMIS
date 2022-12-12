<?php

namespace App\Models\HRIS;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'user_id',
        'role_id',
        'company_id',
        'created_by',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getRoleByUserIdAndCompanyId($userId,$companyId)
    {
        return self::where('user_id',$userId)->where('company_id',$companyId)->first();
    }
}
