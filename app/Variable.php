<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $table = 'variables';
    //
    public function environment(){
        return $this->belongsTo('App\Environment', 'environment_id', 'id');
    }
}
