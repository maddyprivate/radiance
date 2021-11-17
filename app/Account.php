<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $guarded = [];

    /**
     * Get the expenses for the invoice.
     */
    public function expense()
    {
        return $this->hasMany('App\Expense','account_id');
    }
    /**
     * Get the expenses for the invoice.
     */
    public function fromtransfer()
    {
        return $this->hasMany('App\Transfer','fromAccountId');
    }
    /**
     * Get the expenses for the invoice.
     */
    public function totransfer()
    {
        return $this->hasMany('App\Transfer','toAccountId');
    }
}
