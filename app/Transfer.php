<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $guarded = [];
    public function fromaccounts()
    {
        return $this->belongsTo('App\Account','fromAccountId');
    }
    public function toaccounts()
    {
        return $this->belongsTo('App\Account','toAccountId');
    }
}
