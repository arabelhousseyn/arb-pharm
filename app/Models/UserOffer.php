<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOffer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'request_estimate_id',
        'product_name',
        'amount',
        'mark',
        'price'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function images()
    {
        return $this->hasMany(UserOfferImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

    public function request()
    {
        return $this->belongsTo(RequestEstimate::class,'request_estimate_id')->withDefault();
    }
}
