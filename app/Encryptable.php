<?php
/**
 * Created by PhpStorm.
 * User: thomaswalsh
 * Date: 4/22/16
 * Time: 10:42 PM
 */
namespace App;


use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

trait Encryptable
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encryptable)) {
            try{
                $value = Crypt::decrypt($value);
            }catch(\Exception $ex){
                Log::error($ex->getMessage());
            }

        }
        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            $value = Crypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }
}