<?php
/**
 * Created by PhpStorm.
 * User: Chernobyl
 * Date: 4/24/2016
 * Time: 12:32 PM
 */
namespace App\Console\Commands;

use App\Environment;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GetVar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:get {environment} {variable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the value of a variable in a specific environment';

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
        if(!empty($env)){
            $var = $env->variables()->where('name', '=', $this->argument('variable'))->first();
            if(empty($var)){
                $var = $env->firstParentValue($this->argument('variable'));
            }
            if(!empty($var)){
                $this->info($var->value);
            }
            else{
                $this->error('Variable Not Found');
            }
        }
        else{
            $this->error('Environment Not Found');
        }
    }
}