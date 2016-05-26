<?php

namespace tiens;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','rol_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function Banners()
    {
        return $this->hasMany('tiens\Banner','created_by');
    }

    public function News()
    {
        return $this->hasMany('tiens\News','created_by');
    }
    
    public function Events()
    {
        return $this->hasMany('tiens\Event','created_by');
    }

    public function Lions()
    {
        return $this->hasMany('tiens\Lion','created_by');
    }

    public function Trainers()
    {
        return $this->hasMany('tiens\Trainer','created_by');
    }

    public function Training()
    {
        return $this->hasMany('tiens\Training','created_by');
    }

    public function Gallery()
    {
        return $this->hasMany('tiens\Gallery','created_by');
    }

    public function Videos()
    {
        return $this->hasMany('tiens\Video','created_by');
    }

    public function Events_category()
    {
        return $this->hasMany('tiens\Event_category','created_by');
    }

    public function Galleries_category()
    {
        return $this->hasMany('tiens\Gallery_category','created_by');
    }

    public function Training_category()
    {
        return $this->hasMany('tiens\Training_category','created_by');
    }
    
}
