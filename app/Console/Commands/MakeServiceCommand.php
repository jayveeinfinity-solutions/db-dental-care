<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        // Create directory if it doesn't exist
        if (!File::exists(app_path('Services'))) {
            File::makeDirectory(app_path('Services'));
        }

        // Prevent overwriting existing files
        if (File::exists($path)) {
            $this->error("Service {$name} already exists!");
            return Command::FAILURE;
        }

        // Create file content
        $stub = <<<PHP
        <?php

        namespace App\Services;

        class {$name}
        {
            public function __construct()
            {
                //
            }
        }
        PHP;

        // Write the file
        File::put($path, $stub);

        $this->info("Service created successfully: App\\Services\\{$name}");
        return Command::SUCCESS;
    }
}
