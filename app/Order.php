<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function costumer() {
        return $this->belongsTo('App\Costumer', 'costumer_id');
    }

    public function transportation() {
        return $this->belongsTo('App\Transportation', 'transportation_id');
    }

    public function owner() {
        return $this->belongsTo('App\Owner', 'owner_id');
    }
}
