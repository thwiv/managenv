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
use Illuminate\Support\Facades\Storage;

class ExportEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:export {name} {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export env file to location';

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
        if(!empty($env)){
            $filename = $this->argument('location');
            if(is_dir($filename)){
                if(substr($filename, -1) != '/'){
                    $filename .='/';
                }
                $filename.= '.env';
            }
            try{
                Storage::put($filename, $env->fileContent());
            }
            catch(\Exception $ex){
                $this->error($ex->getMessage());
            }
        }
        else{
            $this->error('Environment Not Found');
        }
    }
}