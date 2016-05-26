<?php

namespace tiens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{

	protected $table = 'countries';

	public $timestamps = false;

	public function Banners()
    {
        return $this->belongsToMany('tiens\Banner','bannerxcountry','id_country','id_banner');
    }

    public function Events()
    {
        return $this->hasMany('tiens\Event','country_id');
    }

    public function Lions()
    {
        return $this->hasMany('tiens\Lion','country_id');
    }

    public function Trainers()
    {
        return $this->hasMany('tiens\Trainer','country_id');
    }

    public function Training()
    {
        return $this->belongsToMany('tiens\Training','trainingxcountry','id_country','id_training');
    }

    public function Videos()
    {
        return $this->hasMany('tiens\Video','country_id');
    }
}
