<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $primaryKey = 'id';

    public $timestamps  = false;

    protected $fillable = [
        'author', 'id_auction', 'creation_date', 'content'
    ];



}