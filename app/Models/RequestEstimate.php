<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestEstimate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'amount',
        'mark',
        'is_available'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(RequestEstimateImage::class);
    }
}
