<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $guarded = [];
    public function accounts()
    {
        return $this->belongsTo('App\Account','account_id');
    }
}
