<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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
        'deleted_at',
        'user',
        'images',
        'user_id'

    ];
    protected $appends = ['image','publishedBy','images_request','creation_date'];

    public function getImagesRequestAttribute()
    {
        return $this->images;
    }

    public function getCreationDateAttribute()
    {
        return Carbon::parse($this->created_at)->toDateTimeString();
    }

    public function getPublishedByAttribute()
    {
        return $this->user->profile->commercial_name;
    }

    public function getImageAttribute()
    {
        return (count($this->images) == 0) ? '' : $this->images[0]->path;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(RequestEstimateImage::class);
    }
}
