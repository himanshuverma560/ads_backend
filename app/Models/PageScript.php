<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageScript extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_type',
        'script',
        'position',
    ];
}
