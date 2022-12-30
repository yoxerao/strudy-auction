<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WinnerAuction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'winner_auction';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_notification', 'id_auction',
    ];

    /**
     * The notification for this winner auction.
     */
    public function notification() {
        return $this->belongsTo('App\Models\Notification');
    }

    /**
     * The auction for this notification.
     */
    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}
