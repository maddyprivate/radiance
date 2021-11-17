<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{

    protected $guarded = [];
    /**
     * Get the customer record associated with the invoice.
     */
    public function customer()
    {
        return $this->hasOne('App\CreditNoteCustomer');
    }

    /**
     * Get the products for the invoice.
     */
    public function product()
    {
        return $this->hasMany('App\CreditNoteProduct');
    }

    /**
     * Get the products for the invoice.
     */
    public function payment()
    {
        return $this->hasMany('App\CreditNotePayment');
    }
}
