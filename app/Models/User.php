<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CreatedUpdatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_type',
        'company_id',
        'branch_id',
        'first_name',
        'last_name',
        'mobile',
        'email',
        'email_verified_at',
        'password',
        'created_by',
        'created_by',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        'company_name',
        'full_name'
    ];

    public static function getAllUsers()
    {
        $query = "SELECT u.id, CONCAT(u.first_name, ' ',u.last_name) AS user_name, u.user_type,r.role_name, u.mobile,u.email,u.`status`,
        u.created_at,u.updated_at,CONCAT(cu.first_name,' ',cu.last_name) AS created_by,CONCAT(uu.first_name,' ',uu.last_name)
        AS updated_by,c.company_name
        FROM users u
        LEFT JOIN users cu ON u.created_by=cu.id
        LEFT JOIN users uu ON u.updated_by=uu.id
        JOIN companies c ON u.company_id=c.company_id
        join role_users ru on u.id = ru.user_id
        join roles r on ru.role_id = r.role_id";

        if (auth()->user()->company_id)
            $query .= " AND u.company_id=" . auth()->user()->company_id . " AND u.user_type != 'SUPER ADMIN'";
            
        if (auth()->user()->branch_id)
            $query .= " AND u.branch_id=" . auth()->user()->branch_id . " AND u.user_type != 'COMPANY'";


        $query .= " order by u.id desc";

        return DB::select($query);
        // "SELECT CONCAT(cu.first_name,' ',cu.last_name),c.company_name FROM users u 
        // LEFT JOIN users cu ON u.created_by=cu.id
        // LEFT JOIN companies c ON u.company_id=c.company_id"
    }

    public function getCompanyNameAttribute()
    {
        $company = Company::where('company_id', $this->company_id)->first();
        return $company ? $company->company_name : "";
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
}
