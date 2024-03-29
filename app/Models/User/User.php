<?php

namespace App\Models\User;

use App\Models\AdataDetail\AdataDetail;
use App\Models\Donate\Donate;
use App\Models\Profile\Profile;
use App\Traits\ScopePaginate\ScopePaginate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use PHPZen\LaravelRbac\Traits\Rbac;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, Rbac, Billable, ScopePaginate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function adataDetails()
    {
        return $this->hasMany(AdataDetail::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function donations()
    {
        return $this->hasMany(Donate::class, 'owner_id', 'id');
    }
}
