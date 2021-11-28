<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'technical_sheet_pdf',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'images',
        'ratings',
        'user',
        'user_id'
    ];

    protected $appends = ['rating','image','published_by'];

    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }

    public function ratings()
    {
        return $this->hasMany(ProductRating::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute()
    {
        return (count($this->images) > 0) ? $this->images[0]->path : '';
    }

    public function getPublishedByAttribute()
    {
        return $this->user->profile->commercial_name;
    }

    public function getRatingAttribute()
    {
        $sum = 0;
        foreach ($this->ratings as $rating)
        {
            $sum += $rating->value;
        }
        return (count($this->ratings) == 0) ? 0 : $sum / count($this->ratings);
    }
}
