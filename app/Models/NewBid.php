<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewBid extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'new_bid';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_notification', 'id_bid',
    ];

    /**
     * The notification for this new bid.
     */
    public function notification() {
        return $this->belongsTo('App\Models\Notification');
    }

    /**
     * The bid for this notification.
     */
    public function bid() {
        return $this->belongsTo('App\Models\Bid');
    }
}
