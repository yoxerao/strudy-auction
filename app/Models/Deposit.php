<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deposit';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'date', 'author',
    ];

    public static function getDepositAmount($value){
        switch($value){
            case 'deposit1':
                $amount = '2.50';
            case 'deposit2':
                $amount = '5.00';
            case 'deposit3':
                $amount = '10.00';
            case 'deposit4':
                $amount = '25.00';
            case 'deposit5':
                $amount = '50.00';
            case 'deposit6':
                $amount = '100.00';
            case 'deposit7':
                $amount = '500.00';
            case 'deposit8':
                $amount = '1000.00';
            default:
                $amount = '0.00';
        }
        return $amount;
    }

    /**
     * The user that made this deposit.
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}