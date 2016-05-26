<?php

namespace tiens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class sessionsMath extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'sessionsmath';
}
