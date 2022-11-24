<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
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

    public function user() {
        return $this->belongsTo('App\Models\User');
      }

    /**
     * The cards this user owns.
     */
    # public function cards() {
    #  return $this->hasMany('App\Models\Card');
    #}
}