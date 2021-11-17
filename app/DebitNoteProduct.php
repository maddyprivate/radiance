<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebitNoteProduct extends Model
{
	protected $guarded = [];
	
	public function products()
    {
        return $this->belongsTo('App\DebitNote');
    }
}
