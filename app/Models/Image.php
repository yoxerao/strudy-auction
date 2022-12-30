<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'image';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path_name', 'id_auction', 'id_user',
    ];

    /**
     * The user that uploaded this image.
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * The auction this image belongs to.
     */
    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}