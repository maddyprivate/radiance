<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDealer extends Model
{
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo('App\Purchase');
    }
}
