<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOfferImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_offer_id',
        'path'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];
}
