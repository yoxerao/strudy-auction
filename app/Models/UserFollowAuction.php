<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFollowAuction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_follow_auction';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_auction',
    ];

    /**
     * The user following this auction.
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * The auction being followed.
     */
    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}
