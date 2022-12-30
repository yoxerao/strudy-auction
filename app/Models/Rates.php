<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rates';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating', 'id_rater', 'id_rated',
    ];

    /**
     * The user that made this rate.
     */
    public function rater() {
        return $this->belongsTo('App\Models\User', 'id_rater');
    }

    /**
     * The user that was rated.
     */
    public function rated() {
        return $this->belongsTo('App\Models\User', 'id_rated');
    }
}
