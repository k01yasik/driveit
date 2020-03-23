<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\User
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string|null $email_verified_at
 * @property string|null $password
 * @property string|null $provider
 * @property string|null $provider_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Album[] $albums
 * @property-read int|null $albums_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Friend[] $friends
 * @property-read int|null $friends_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\News[] $news
 * @property-read int|null $news_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @property-read int|null $posts_count
 * @property-read \App\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rating[] $rating
 * @property-read int|null $rating_count
 * @property-read \App\Rip $rip
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Draft[] $drafts
 * @property-read int|null $drafts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, HasApiTokens;

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
        'password', 'remember_token', 'provider', 'provider_id'
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function news() {
        return $this->hasMany('App\News');
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

    public function drafts()
    {
        return $this->hasMany('App\Draft');
    }
}
