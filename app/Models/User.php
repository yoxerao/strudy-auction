<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'balance', 'rating', 'banned', 'blocked', 'terminated', 'username', 'email', 'password', 'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The auctions this user has created.
     */
    public function auctions()
    {
        return $this->hasMany('App\Models\Auction');
    }

    /**
     * The bids this user has made.
     */
    public function bids()
    {
        return $this->hasMany('App\Models\Bid');
    }

    /**
     * The deposits this user has made.
     */
    public function deposits()
    {
        return $this->hasMany('App\Models\Deposit');
    }

    /**
     * The images this user has uploaded.
     */
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    /**
     * The notifications this user has received.
     */
    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    /**
     * The users this user has rated.
     */
    public function ratedUsers()
    {
        return $this->belongsToMany('App\Models\User', 'rates', 'id_rater', 'id_rated');
    }

    /**
     * The users that have rated this user.
     */
    public function raterUsers()
    {
        return $this->belongsToMany('App\Models\User', 'rates', 'id_rated', 'id_rater');
    }
}
