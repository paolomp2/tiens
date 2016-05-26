<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery_category extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'gallery_category';

    public function Galleries()
    {
    	return $this->hasMany('App\Gallery', 'id_category');
    }

    public function Created_by(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }
}
