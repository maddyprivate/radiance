<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DcCustomer extends Model
{
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo('App\Dc');
    }
}
