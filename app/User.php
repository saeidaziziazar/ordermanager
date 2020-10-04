<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function permissions() {
        return $this->belongsToMany('App\Permission');
    }

    public function transportation() {
        return $this->belongsTo('App\Transportation');
    }
}
