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
    public function firstParentValue($name){
        $p = $this->parent;
        while(!empty($p)){
            foreach($p->variables as $var){
                if($var->name == $name){
                    return $var;
                }
            }
            $p = $p->parent;
        }
        return null;
    }

    public function fullVariableList(){
        $var_list = [];
        $p = $this;
        do{
            foreach($p->variables as $var){
                if(!array_key_exists($var->name, $var_list)){
                    $var_list[$var->name] = $var;
                }
            }
            $p = $p->parent;
        }while(!empty($p));
        return $var_list;
    }
    public function fileContent(){
        $content = "";
        $variables = $this->fullVariableList();
        foreach($variables as $var){
            $content.= $var->name.'='.$var->value."\n";
        }
        return $content;
    }
}
