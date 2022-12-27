<?php

namespace App\Models\Leave\LeaveRequest;

use App\Models\Leave\LeaveTypes\LeaveTypes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class LeaveRequest extends Model
{
    use HasFactory;

    use Sluggable;

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name','slug','user_id','date','start_date','end_date','sub_total','description','leave_type','total_annual_leave','total_sick_leave',
        'created_by','type','status','status_user','approved_date','last_updated_by','last_deleted_by',''
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function leavetype(){
        return $this->belongsTo(LeaveTypes::class,'leave_type','id');
    }

    public function statusUser(){
        return $this->belongsTo(User::class,'status_user','id');
    }

    public function rejectedBy(){
        return $this->belongsTo(User::class,'rejected_by','id');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class,'last_updated_by','id');
    }
}
