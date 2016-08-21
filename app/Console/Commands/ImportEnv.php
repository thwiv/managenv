<?php
/**
 * Created by PhpStorm.
 * User: thomaswalsh
 * Date: 4/22/16
 * Time: 10:55 PM
 */

namespace App\Console\Commands;

use App\Environment;
use App\Variable;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\File;
use League\Flysystem\FileNotFoundException;

class ImportEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:import {location} {--name=} {--parent=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import env file from location';

    protected $environment;

    public function __construct(Environment $environment)
    {
        parent::__construct();
        $this->environment = $environment;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //first read in the file, make sure it exists

        try{
            if(file_exists($this->argument('location'))){
                $all = file_get_contents($this->argument('location'));
                $envName = $this->option('name');

                if(empty($envName)){
                    $envName = explode('.', $this->argument('location'))[0];
                    if(empty($envName)){
                        $envName = 'default';
                    }
                }
                $env = $this->environment->where('name', '=', $envName)->first();
                $parent = null;
                if(!empty($this->option('parent'))){
                    $parent = $this->environment->where('name', '=', $this->option('parent'))->first();
                    if(empty($parent)){
                        $this->error('Parent Not Found');
                        return;
                    }
                }
                if(empty($env)){
                    $env = new Environment();
                    $env->name = $envName;
                    if(!empty($parent)){
                        $env->parent_id = $parent->id;
                    }
                    $env->save();
                }
                else if(!empty($parent) && $parent->id  != $env->parent_id){
                     $this->error('Parent is not associated with the environment');
                    return;
                }
                $lines = explode("\n", $all);
                foreach($lines as $line){
                    $line = trim($line);
                    if(empty($line) || str_is('#.*', $line)){
                        continue;
                    }
                    $split = explode("=", $line, 2);
                    if(count($split) == 2){
                        $varName = $split[0];
                        $value = $split[1];
                        $var = $env->variables()->where('name', '=', $varName)->first();
                        if(empty($var)){
                            $var = new Variable();
                            $var->environment_id = $env->id;
                            $var->name = $varName;
                        }
                        $var->value = $value;
                        $var->save();
                    }
                    else{
                        $this->warn("Could Not Read Variable: ".$line);
                    }
                }
            }
            else{
                $this->error("The file does not exist");
            }
        }
        catch(\Exception $ex){

            $this->error("An Error Occured Importing The File: ".$ex->getMessage());
            $this->info($ex->getTraceAsString());
        }
    }
}