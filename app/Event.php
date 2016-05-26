<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'events';

    public function Category(){
    	return $this->belongsTo('tiens\Event_category','category_id'); 
    }

    public function User(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }

    public function Country(){
    	return $this->belongsTo('tiens\Country','country_id'); 
    }
}
