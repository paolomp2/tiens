<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'notifications';

    public function Country(){
    	return $this->belongsTo('tiens\Country','country_id'); 
    }
}
