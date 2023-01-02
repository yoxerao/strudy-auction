<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bid';

    // * We want to keep a record of all bids on the bd because of the user history.
    use SoftDeletes;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'date', 'winner', 'user_id', 'id_auction',
    ];

    /**
     * The user that made this bid.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * The auction this bid was made on.
     */
    public function auction()
    {
        return $this->belongsTo('App\Models\Auction');
    }
}
