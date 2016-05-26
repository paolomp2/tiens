<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $table = 'galleries';


	public function User(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }

    public function Countries(){
    	return $this->belongsToMany('tiens\Country','galleryxcountry','id_gallery','id_country');
    }

    public function category(){
        return $this->belongsTo('tiens\Gallery_category','category_id'); 
    }

    /*Las im'agenes se manejar'an como documentos de tipo imagen*/
    public function Documents(){
        return $this->hasMany('tiens\Document','father_id');
    }
}

