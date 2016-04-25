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
use Illuminate\Support\Facades\File;
use League\Flysystem\FileNotFoundException;

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
        //first read in the file, make sure it exists



    }
}