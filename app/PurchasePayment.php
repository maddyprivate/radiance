<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    protected $guarded = [];

    public function purchase()
    {
        return $this->belongsTo('App\Purchase');
    }
}
