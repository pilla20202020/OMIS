<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Company extends Model
{
    use HasFactory,CreatedUpdatedBy;

    protected $primaryKey = 'company_id';

    protected $fillable = [
        'user_id',
        'company_name',
        'company_email',
        'company_phone',
        'company_mobile',
        'company_address',
        'created_by',
        'created_by',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
