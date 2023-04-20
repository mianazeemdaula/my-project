<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;

    protected $fillable = [
        'live'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'category_id' => 'integer',
        'city_id' => 'integer',
    ];
}
