<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function costumer() {
        return $this->belongsTo('App\Costumer', 'costumer_id');
    }
}
