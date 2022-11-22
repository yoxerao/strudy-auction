<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'administrator';

    protected $fillable = [
        'username', 'email', 'password', 'name',   
    ];

    protected $hidden = [
        'password', 'remember_token', 
    ];
}