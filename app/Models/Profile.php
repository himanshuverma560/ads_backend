<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'whatsapp',
        'facebook',
        'insta_id',
        'telegram_id',
        'snapchat',
        'video_call_link',
        'about_us',
        'city',
        'city_id',
        'state_id',
        'country_id',
        'age',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
