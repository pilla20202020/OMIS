<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'company_id',
        'branch_id',
        'employee_id',
        'year',
        'date',
        'status',
        'present_type',
        'leave_type_id',
        'late_minute',
        'reason',
        'time_in',
        'time_out',
        'created_by',
        'updated_by',
    ];

   /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'day',
    ];

    public function getDayAttribute()
    {
         $timestamp =  $this->date? strtotime($this->date) : null;
        return  date("j", $timestamp);
    }

}
