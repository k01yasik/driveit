<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {service : Service name} {--M|model= : Model name for use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fileName = $this->argument('service');
        $fileFullName = $fileName.'.php';
        $instance = Storage::disk('app');
        $exists = $instance->exists('Services'.DIRECTORY_SEPARATOR.$fileFullName);
        $modelName = $this->option('model');

        if (!$exists) {
            $this->info('File do not exist.');

            $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, '<?php');
            $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, '');
            $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, 'namespace App\Services;');
            $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, '');
            if ($modelName) {
                $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, 'use App\\' . $modelName . ';');
            }
            $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, '');
            $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, 'class ' . $fileName);
            $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, '{');
            $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, '');
            $instance->append('Services'.DIRECTORY_SEPARATOR.$fileFullName, '}');

            $this->info('Service class created successfully.');

        } else {
            $this->info('File already exist.');
        }
    }
}