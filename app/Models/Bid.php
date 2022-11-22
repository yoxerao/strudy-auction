<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

class Auction
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
        'value', 'date', 'winner', 'bidder', 'id_auction',   
    ];

    /**
     * The cards this user owns.
     */
    # public function cards() {
    #  return $this->hasMany('App\Models\Card');
    #}
}
