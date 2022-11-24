<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

   
    public function bids() {
      return $this->hasMany('App\Models\Bid');
    }

    public function auctions() {
        return $this->hasMany('App\Models\Auction');
    }

}
