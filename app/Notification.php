<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = true;
    protected $table = 'categories';
    protected $fillable = [
        'user_logged','user_hero','note','status',
    ];
}
