<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\QueryScopes;
use App\Models\ProductReview;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, MustVerifyEmail, Notifiable, QueryScopes;

    const ROLE_ADMIN = 1;

    const ROLE_CUSTOMER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'user_catalogue_id',
        'phone',
        'province_id',
        'district_id',
        'ward_id',
        'google_id',
        'address',
        'birthday',
        'description',
        'publish',
        'ip',
        'user_agent',
        'email',
        'password',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'ip',
        'user_agent',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\EmailRegisterVerifyNotification);
    }

    public function user_catalogue()
    {
        return $this->belongsTo(UserCatalogue::class);
    }

    public function system_configurations()
    {
        return $this->hasMany(SystemConfiguration::class);
    }

    // relationship cart
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'code');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'code');
    }

    public function product_reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function orders()
    {

        return $this->hasMany(Order::class);
    }
}
