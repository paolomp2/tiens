<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $table = 'video';


	public function User(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }

    public function Category(){
        return $this->belongsTo('tiens\Video_category','category_id'); 
    }

    public function Country(){
        return $this->belongsTo('tiens\Country','country_id'); 
    }
}
