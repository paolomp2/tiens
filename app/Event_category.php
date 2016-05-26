<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event_category extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'events_category';

    public function Events()
    {
    	return $this->hasMany('App\Event', 'id_category');
    }

    public function User(){
        return $this->belongsTo('tiens\User','created_by'); 
    }

}
