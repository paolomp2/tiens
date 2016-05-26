<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training_category extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $table = 'training_category';
	
    public function User(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }

    public function Country(){
    	return $this->belongsTo('tiens\Country','country_id'); 
    }

    public function Trainings()
    {
        return $this->hasMany('App\Training', 'id_category');
    }
}
