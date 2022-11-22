<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;



class Auction
{
    use Notifiable;

    protected $table = 'auction';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'buyout_value', 'min_bid', 'description', 'start_date', 'end_date', 'winner', 'owner',   
    ];

    /**
     * The cards this user owns.
     */
    # public function cards() {
    #  return $this->hasMany('App\Models\Card');
    #}
}
