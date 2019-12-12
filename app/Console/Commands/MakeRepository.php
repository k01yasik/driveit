<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository : Repository name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

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
        $repository_directory = app_path().DIRECTORY_SEPARATOR.'Repositories';
        $dir_repository = File::isDirectory($repository_directory);
        $argument_repositroy_name = $this->argument('repository');

        if (!$dir_repository)
        {
            Storage::makeDirectory($repository_directory);

            $this->info('Created directory repositories.');

        } else {
            $interface_directory = $repository_directory .DIRECTORY_SEPARATOR. 'Interfaces';

            $check_interface_dir = File::isDirectory($interface_directory);

            if (!$check_interface_dir)
            {
                Storage::makeDirectory($interface_directory);

                $this->info('Created directory interfases.');

            } else {
                $instance = Storage::disk('app');

                $fileInterfaceClass = $argument_repositroy_name.'RepositoryInterface';
                $fileInterfaceFullName = $fileInterfaceClass.'.php';
                $fileRepositoryClass = $argument_repositroy_name.'Repository';
                $fileRepositoryFullName = $fileRepositoryClass.'.php';

                $instance->append('Repositories'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR.$fileInterfaceFullName, '<?php');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR.$fileInterfaceFullName, '');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR.$fileInterfaceFullName, 'namespace App\Repositories\Interfaces;');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR.$fileInterfaceFullName, '');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR.$fileInterfaceFullName, 'interface '.$fileInterfaceClass );
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR.$fileInterfaceFullName, '{');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR.$fileInterfaceFullName, '');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR.$fileInterfaceFullName, '}');

                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, '<?php');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, '');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, 'namespace App\Repositories;');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, '');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, 'use App\Repositories\Interfaces\\'.$fileInterfaceClass.';');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, '');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, 'class '.$fileRepositoryClass.' implements '.$fileInterfaceClass);
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, '{');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, '');
                $instance->append('Repositories'.DIRECTORY_SEPARATOR.$fileRepositoryFullName, '}');
            }
        }
    }
}
