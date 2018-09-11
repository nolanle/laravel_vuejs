<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'avatar', 'username','email', 'password', 'company_id', 'activated',
    ];

    /**
     * The attributes that should be hidden for arrays.
    avatar
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get Avatar From User.
     *
     * @return mixed
     */
    public function getAvatar() {
        return $this->avatar == 'g-avatar' ? Gravatar::src($this->email, 200) : Storage::url($this->avatar);
    }

    /**
     * Get JWT Identifier.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Get JWT Custom Claims.
     *
     * @return mixed
     */
    public function getJWTCustomClaims() {
        return [];
    }

    /**
     * Get List Of Activities.
     *
     * @return mixed
     */
    public function activities() {
        return $this->hasMany(Activity::class, 'causer_id', 'id');
    }

}
