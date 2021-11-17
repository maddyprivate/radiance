<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dc extends Model
{

    protected $guarded = [];
    /**
     * Get the customer record associated with the dc.
     */
    public function customer()
    {
        return $this->hasOne('App\DcCustomer');
    }

    /**
     * Get the products for the dc.
     */
    public function product()
    {
        return $this->hasMany('App\DcProduct');
    }
}
