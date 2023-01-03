<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    public $timestamps  = false;
    protected $table = 'validation';
    protected $primaryKey = 'id_report';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'banned', 'id_administrator', 'id_report',
    ];

    public function report()
    {
        return $this->belongsTo('App\Models\Report', 'id_report');
    }

    public function administrator()
    {
        return $this->belongsTo('App\Models\Administrator', 'id_administrator');
    }
}
