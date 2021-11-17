<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

    protected $guarded = [];
    /**
     * Get the dealer record associated with the invoice.
     */
    public function dealer()
    {
        return $this->hasOne('App\PurchaseDealer');
    }

    /**
     * Get the products for the invoice.
     */
    public function product()
    {
        return $this->hasMany('App\PurchaseProduct');
    }
}
