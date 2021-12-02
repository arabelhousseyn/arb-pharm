<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'phone',
        'email',
        'password',
        'token',
        'days',
        'type',
        'activated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
        'codeActivity',
        'activated_at',
        'profile',
        'category',
        'activated_at',
        'days'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['is_active','profile_name','category_user_type','date_creation','activation','activation_date'];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function codeActivity()
    {
        return $this->hasOne(UserActivityCode::class);
    }

    public function getProfileNameAttribute()
    {
        return $this->profile->commercial_name;
    }

    public function payments()
    {
        return $this->hasMany(UserPayment::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(ProductUser::class,'product_user','user_id','product_id');
    }

    public function requests()
    {
        return $this->hasMany(RequestEstimate::class);
    }

    public function category()
    {
        return $this->hasOne(UserCategory::class);
    }

    public function getCategoryUserTypeAttribute()
    {
        return ($this->category == null) ? '' : $this->category->category;
    }


    public function getIsActiveAttribute()
    {
        if($this->activated_at == null)
        {
            return false;
        }else{
            $now = Carbon::now();
            $activation_date = Carbon::parse($this->activated_at);
            $days = $now->diffInDays($activation_date);
            if($days > $this->days)
            {
                return false;
            }else{
                return true;
            }
        }
    }

    public function getDateCreationAttribute()
    {
        return Carbon::parse($this->created_at)->toDateString();
    }

    public function getActivationAttribute()
    {
        if($this->activated_at == null)
        {
            return 'Non activé';
        }else{
            $now = Carbon::now();
            $activation_date = Carbon::parse($this->activated_at);
            $days = $now->diffInDays($activation_date);
            if($days > $this->days)
            {
                return 'Expiré';
            }else{
                return 'Activé';
            }
        }
    }

    public function getActivationDateAttribute()
    {
        return ($this->activated_at == null) ? '/' : Carbon::parse($this->activated_at)->toDateString();
    }

}
