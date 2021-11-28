<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commercial_name',
        'num_rc',
        'nif',
        'nis',
        'num_ar',
        'pro_card',
        'adress',
        'job',
        'description'
    ];
}
