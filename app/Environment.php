<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
    //
    protected $table = 'environments';

    public function parent(){
        return $this->belongsTo('App\Environment', 'parent_id', 'id');
    }
    public function children(){
        return $this->hasMany('App\Environment', 'parent_id', 'id');
    }

    public function variables(){
        return $this->hasMany('App\Variable', 'environment_id', 'id');
    }
}
