<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'creation_date', 'seen', 'id_user',
    ];

    /**
     * The user that received this notification.
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
