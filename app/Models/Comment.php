<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $primaryKey = 'id_content';

    public $timestamps  = false;

    protected $fillable = [
        'author', 'id_auction', 'creation_date', 'content'
    ];



}