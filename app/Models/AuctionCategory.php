<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auction_category';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_auction', 'id_category',
    ];

    /**
     * The auction for this category.
     */
    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }

    /**
     * The category for this auction.
     */
    public function category() {
        return $this->belongsTo('App\Models\Category');
    }
}
