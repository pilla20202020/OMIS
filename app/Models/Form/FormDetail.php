<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'form_detail',
        'form_name',
        'last_valid_date',
        'status',
        'created_by',
        'updated_by',
    ];
}
