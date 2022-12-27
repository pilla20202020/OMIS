<?php

namespace App\Models\Leave\UserLeaveEntitlements;

use App\Models\Leave\LeaveTypes\LeaveTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeaveEntitlements extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','leave_type','total_days','created_by','updated_by'
    ];

    public function leavetype()
    {
        return $this->belongsTo(LeaveTypes::class,'leave_type','id');
    }
}
