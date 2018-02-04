<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;
    protected $table = 'posts';
    protected $fillable = [
        'user_id','content','status',
    ];
}
