<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
