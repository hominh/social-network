<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = true;
    //protected $table = 'notifications';
    protected $fillable = [
        'user_logged','user_hero','note','status',
    ];
}
