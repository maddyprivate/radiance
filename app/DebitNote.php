<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model
{

    protected $guarded = [];
    /**
     * Get the dealer record associated with the invoice.
     */
    public function dealer()
    {
        return $this->hasOne('App\DebitNoteDealer');
    }

    /**
     * Get the products for the invoice.
     */
    public function product()
    {
        return $this->hasMany('App\DebitNoteProduct');
    }

    /**
     * Get the products for the invoice.
     */
    public function payment()
    {
        return $this->hasMany('App\DebitNotePayment');
    }
}
