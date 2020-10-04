<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    // Transportation has many orders
    
    public function orders() {
        return $this->hasMany('App\Order')->orderBy('order_num', 'desc');
    }

    public function users() {
        return $this->hasMany('App\User');
    }
}
