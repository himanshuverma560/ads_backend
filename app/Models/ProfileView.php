<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileView extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'ip_address',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
