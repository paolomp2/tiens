<?php

namespace tiens;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Lion extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
	
    public function User(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }

    public function Country(){
    	return $this->belongsTo('tiens\Country','country_id'); 
    }
}
