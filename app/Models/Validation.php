<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'validation';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'id_user',
    ];

    /**
     * The user who requested this validation.
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
