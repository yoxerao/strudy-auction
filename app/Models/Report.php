<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason', 'id_auction', 'id_user',
    ];

    /**
     * The user who made this report.
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * The auction for this report.
     */
    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}
