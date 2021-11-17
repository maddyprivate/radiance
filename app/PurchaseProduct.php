<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
	protected $guarded = [];
	
	public function products()
    {
        return $this->belongsTo('App\Purchase');
    }
}
