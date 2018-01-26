<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'city','country','about','user_id'
    ];

    public function profile() {
        return $this->hasOne('App\profile');
    }
    public function friendships()
    {
        return $this->hasMany(Friendship::class);
    }
}
