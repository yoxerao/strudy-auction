<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{

    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auction';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'buyout_value', 'min_bid', 'description', 'start_date', 'end_date', 'winner', 'user_id',
    ];

    /**
     * The user that created this auction.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * The bids made on this auction.
     */
    public function bids()
    {
        return $this->hasMany('App\Models\Bid');
    }

    /**
     * The images associated with this auction.
     */
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
}
