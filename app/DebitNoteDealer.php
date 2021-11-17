<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebitNoteDealer extends Model
{
    protected $guarded = [];

    public function debitnote()
    {
        return $this->belongsTo('App\DebitNote');
    }
}
