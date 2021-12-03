<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ProductUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id'
    ];

    protected $hidden = [
        'created_at'
    ];

    protected $appends = ['creation_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getCreationDateAttribute()
    {
        return Carbon::parse($this->created_at)->toDateTimeString();
    }
}
