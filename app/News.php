<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'news';

    public function Countries()
    {
        return $this->belongsToMany('tiens\Country','newsxcountry','id_news','id_country');
    }

    public function User(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }
}
