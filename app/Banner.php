<?php

namespace tiens;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'banners';

    public function Countries()
    {
        return $this->belongsToMany('tiens\Country','bannerxcountry','id_banner','id_country');
    }

    public function User(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }
}
