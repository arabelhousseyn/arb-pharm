<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'value'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
