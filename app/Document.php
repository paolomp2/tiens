<?php

namespace tiens;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];	

}
