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
        'reason', 'author', 'reported',
    ];

    /**
     * The user who made this report.
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author');
    }

    public function reported()
    {
        return $this->belongsTo('App\Models\User', 'reported');
    }

    public function validation()
    {
        return $this->hasOne('App\Models\Validation', 'id_report');
    }
}
