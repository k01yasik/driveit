<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'provider', 'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function rip()
    {
        return $this->hasOne('App\Rip');
    }

    public function friends()
    {
        return $this->hasMany('App\Friend');
    }

    public function albums()
    {
        return $this->hasMany('App\Album');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function rating()
    {
        return $this->hasMany('App\Rating');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
