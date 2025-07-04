<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\ProfileView;

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

    public function cityRelation()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function views()
    {
        return $this->hasMany(ProfileView::class);
    }
}
