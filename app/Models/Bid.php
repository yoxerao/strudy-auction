<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bid';

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
     * The cards this user owns.
     */
    # public function cards() {
    #  return $this->hasMany('App\Models\Card');
    #}
}
