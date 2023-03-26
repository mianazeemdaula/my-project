<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => 'boolean',
        'min_purchase' => 'double',
        'max_discount' => 'double',
        'discount' => 'double',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
