<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNoteProduct extends Model
{
	protected $guarded = [];
	
	public function products()
    {
        return $this->belongsTo('App\CreditNote');
    }
}
