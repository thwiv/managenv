<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use Encryptable;

    protected $table = 'variables';
    protected $encryptable = ['value'];
    //
    public function environment(){
        return $this->belongsTo('App\Environment', 'environment_id', 'id');
    }
}
