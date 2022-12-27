<?php

namespace App\Models\Leave\LeaveTypes;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveTypes extends Model
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
        'name','slug','total_days'
    ];
}
