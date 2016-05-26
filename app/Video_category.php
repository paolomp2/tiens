<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video_category extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'video_category';

    public function Videos()
    {
    	return $this->hasMany('App\Video', 'id_category');
    }

    public function Created_by(){
    	return $this->belongsTo('tiens\User','created_by'); 
    }
}