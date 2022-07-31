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
    use HasApiTokens, HasFactory, HasRoles,SoftDeletes,Notifiable;

    const clientA = 'A';
    const clientB = 'B';
    const clientR = 'R';

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
        'code_verification',
        'type',
        'activated_at',
        'expired_at',
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
        'profile',
        'activated_at',
        'code_verification'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['is_active','profile_name','date_creation','activation','activation_date','get_profile'];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function getProfileNameAttribute()
    {
        return (@$this->profile->commercial_name !== null) ? $this->profile->commercial_name : null;
    }

    public function payments()
    {
        return $this->hasMany(UserPayment::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }



    public function requests()
    {
        return $this->hasMany(RequestEstimate::class);
    }

    public function subscribeHistory()
    {
        return $this->hasMany(UserSubscribe::class);
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($user) {
            $user->profile()->each(function($profile) {
                $profile->delete();
            });

            $user->payments()->each(function($payment) {
                $payment->delete();
            });

            $user->products()->each(function($product) {
                $product->delete();
            });

            $user->favorites()->each(function($favorite) {
                $favorite->delete();
            });

            $user->requests()->each(function($request) {
                $request->delete();
            });
        });
    }




    public function getIsActiveAttribute()
    {
        if($this->activated_at == null && $this->expired_at == null)
        {
            return false;
        }else{
            $now = Carbon::now();
            $activation_date = Carbon::parse($this->activated_at);
            if($activation_date > $this->expired_at)
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

        if($this->activated_at == null && $this->expired_at == null)
        {
            return 'Non activé';
        }else{
            $now = Carbon::now();
            $activation_date = Carbon::parse($this->activated_at);
            if($activation_date > $this->expired_at)
            {
                return 'Expiré';
            }else{
                return 'Activé';
            }
        }
    }

    public function getActivationDateAttribute()
    {
        return ($this->activated_at == null) ? '' : Carbon::parse($this->activated_at)->toDateString();
    }

    public function getGetProfileAttribute()
    {
        return $this->profile;
    }

}
