<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'profile_pic',
        'social_name',
        'social_place',
        'commercial_name',
        'num_rc',
        'nif',
        'nis',
        'num_ar',
        'activity_code'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }
}
