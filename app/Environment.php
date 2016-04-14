<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
    //
    protected $table = 'environments';

    public function parent(){
        return $this->hasOne('App\Environment', 'parent_id', 'id');
    }
    public function variables(){
        return $this->hasMany('App\Variable', 'environment_id', 'id');
    }
}
