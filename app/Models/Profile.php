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
        'facebook',
        'insta_id',
        'telegram_id',
        'about_us',
        'city',
        'age',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
