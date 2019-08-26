<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Users extends Model implements Authenticatable
{
    //
    use AuthenticableTrait;
    protected $fillable = ['name', 'email', 'password', 'userimage'];
    protected $hidden = [
        'password'
    ];

    /*
   * Get Heros of User
   *
   */
    public function heros()
    {
        return $this->belongsToMany('App\Hero')->withTimestamps();;
    }
}
