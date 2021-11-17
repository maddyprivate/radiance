<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNoteCustomer extends Model
{
    protected $guarded = [];

    public function creditnote()
    {
        return $this->belongsTo('App\CreditNote');
    }
}
