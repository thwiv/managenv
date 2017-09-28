<?php
/**
 * Created by PhpStorm.
 * User: Chernobyl
 * Date: 4/24/2016
 * Time: 12:32 PM
 */
namespace App\Console\Commands;

use App\Environment;
use App\Variable;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SetVar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set {environment : The name of the environment to edit} {variable : The name of the variable} {value : The value you wish to set}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the value of a variable in a specific environment';

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
        $env = $this->environment->where('name', '=', $this->argument('environment'))->first();
        $variable_name = strtoupper($this->argument('variable'));
        if(!empty($env)){
            $var = $env->variables()->where('name', '=', $variable_name)->first();
            if(empty($var)){
                $var = new Variable();
                $var->name = $variable_name;
            }
            $var->value = $this->argument('value');
            $var->save();
            $this->info('Variable Saved');
        }
        else{
            $this->error('Environment Not Found');
        }
    }
}