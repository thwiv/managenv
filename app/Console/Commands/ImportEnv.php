<?php
/**
 * Created by PhpStorm.
 * User: thomaswalsh
 * Date: 4/22/16
 * Time: 10:55 PM
 */

namespace App\Console\Commands;

use App\Environment;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class ImportEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:import {location} {name} {--parent=}';

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
        $env = $this->environment->where('name', '=', $this->argument('name'))->first();
        if(empty($env)){
            $env = new Environment();
            $env->name = $this->argument('name');
            $parent = $this->option('parent');
            if(!empty($parent)){
                $p = $this->environment->where('name', '=', $parent)->first();
                if(!empty($p)){
                    $env->parent_id = $p->id;
                }
            }
            $env->save();
        }

    }
}