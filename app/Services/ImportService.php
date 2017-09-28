<?php
namespace App\Services;

use App\Environment;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use League\Flysystem\FileNotFoundException;

/**
 * Class ImportService
 * @package App\Services
 * @codeCoverageIgnore
 */
class ImportService
{
    private $environment;
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    private function getVarValue($row){
        $spl = explode("=", $row, 1);
        if(count($spl) == 2){
            if(preg_match('[^s]+', $spl[0])){
                return false;
            }
            else{
                return [strtoupper($spl[0]), $spl[1]];
            }
        }
        else{
            return false;
        }
    }

    private function getEnvironment($env_name, $parent_name = null){

    }
    public function import($filename, $env_name, $parent_name = null){
        $content = file_get_contents($filename);
        if($content === FALSE){
            throw new FileNotFoundException($filename);
        }
        else{
            $lines = explode("\n", $content);

            $env = $this->environment->where('name', '=', $env_name)->first();
            $parent = null;
            if(!empty($parent_name)){
                $parent = $this->environment->where('name', '=', $parent_name)->first();
            }
            if(empty($env)){
                $env = new Environment();
                $env->name = $env_name;
                if(!empty($parent_name)){
                    
                    if(empty($parent)){
                        $this->error('Parent Not Found');
                        return;
                    }
                    else{
                        $env->parent_id = $parent->id;
                    }
                }
                $env->save();
            }
        }
    }
}