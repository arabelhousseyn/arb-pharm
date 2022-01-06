<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
class RequestEstimate extends Model
{
    use HasFactory,SoftDeletes,Searchable;

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

    public function searchableAs()
    {
        return 'request_estimate_index';
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(RequestEstimateImage::class);
    }



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
        return ($this->user->profile) ? $this->user->profile->commercial_name : '';
    }

    public function getImageAttribute()
    {
        return (count($this->images) == 0) ? '' : $this->images[0]->path;
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($RequestEstimate) {
            $RequestEstimate->images()->each(function($image) {
                $image->delete();
            });
        });
    }
}
