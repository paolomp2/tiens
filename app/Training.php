<?php

namespace tiens;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $table = 'training';
	
    public function User(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }

    public function Countries(){
    	return $this->belongsToMany('tiens\Country','trainingxcountry','id_training','id_country');
    }

    public function category(){
        return $this->belongsTo('tiens\Training_category','category_id'); 
    }

    public function Documents(){
        return $this->hasMany('tiens\Document','father_id');
    }
}