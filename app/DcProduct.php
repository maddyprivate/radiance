<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DcProduct extends Model
{
	protected $guarded = [];
	
	public function products()
    {
        return $this->belongsTo('App\Dc');
    }
}
