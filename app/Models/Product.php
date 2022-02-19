<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    const clientA = 'A';
    const clientB = 'B';
    const clientR = 'R';

    protected $fillable = [
        'description',
        'technical_sheet_pdf',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'ratings',
        'user_id',
        'favorites'
    ];

    protected $appends = ['rating','image','published_by','product_images','is_favorits','phone','my_favorits','creation_date'];

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
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

    public function favorites()
    {
        return $this->hasMany(ProductUser::class);
    }


    public static function boot() {
        parent::boot();
        self::deleting(function($product) {
            $product->images()->each(function($image) {
                $image->delete();
            });
            $product->ratings()->each(function($rating) {
                $rating->delete();
            });
            $product->favorites()->each(function($favorite) {
                $favorite->delete();
            });
        });
    }

    public function getMyFavoritsAttribute()
    {
        return $this->favorites;
    }

    public function getImageAttribute()
    {
        return (count($this->images) > 0) ? $this->images[0]->path : '';
    }

    public function getProductImagesAttribute()
    {
        return $this->images;
    }

    public function getPublishedByAttribute()
    {
        return (@$this->user->profile->commercial_name !== null) ? $this->user->profile->commercial_name : '';
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone;
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

    public function getIsFavoritsAttribute()
    {
        $bool = false;
        foreach ($this->favorites as $favorite)
        {
            if(Auth::id() == $favorite->user_id)
            {
                $bool = true;
            }
        }
        return $bool;
    }

    public function getCreationDateAttribute()
    {
        return Carbon::parse($this->created_at)->toDateTimeString();
    }
}
