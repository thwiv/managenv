<?php
/**
 * Created by PhpStorm.
 * User: Chernobyl
 * Date: 4/24/2016
 * Time: 12:54 PM
 */
namespace App\Console\Commands;

use App\Environment;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CreateEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:create {name} {--parent=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Environment';

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
        $env = $this->environment->where('name', '=', $this->argument('name'))->first();
        if(empty($env)) {
            $parent = null;
            $env = new Environment();
            $env->name = $this->argument('name');
            if($this->option('parent')){
                $parent = $this->environment->where('name', '=', $this->option('parent'))->first();
                if(empty($parent)){
                    $this->error('Parent Does Not Exist');
                    return;
                }
                else{
                    $env->parent_id = $parent->id;
                }
            }
            $env->save();
            $this->info('Environment '.$env->name.' Created');
        }
        else{
            $this->error('Environment Already Exists');
        }
    }
}