<?php

namespace App\Models\LMS;

use App\Models\Registration\Registration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'tbl_campaigns';
    use HasFactory;

    protected $path = 'uploads/campaign';

    protected $fillable = [
        'name',
        'alias',
        'details',
        'banner',
        'ogImage',
        'starts',
        'ends',
        'ogtags',
        'success_message',
        'sms_message',
        'email_success',
        'coupon_codes',
        'offered_course',
        'url',
        'keywords',
        'headers',
        'description',
        'display_order',
        'remarks',
        'status',
        'created_by',
        'created_on',
    ];

    protected $appends = [
        'banner_thumbnail_path', 'banner_path', 'ogImage_path', 'ogImage_thumbnail_path'
    ];


    function getOgImagePathAttribute()
    {
        return $this->path . '/' . $this->ogImage;
    }

    function getOgImageThumbnailPathAttribute()
    {
        return $this->path . '/thumb/' . $this->ogImage;
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }


}
