<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    public $timestamps  = false;

    protected $table = 'administrator';

    protected $fillable = [
        'username', 'email', 'password', 'name',   
    ];

    protected $hidden = [
        'password', 'remember_token', 
    ];
}