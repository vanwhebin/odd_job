<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResourcesGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resources {name : Class (singular) for example User} --{menu : Menu (singular) for example Api}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Model resource and resourceCollection';

    protected function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }

    protected function resource($name, $menu)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}', '{{menu}}'],
            [$name, $menu],
            $this->getStub('Resource')
        );
        if (!file_exists($path = app_path("/Http/Resources/{$menu}"))) {
            mkdir($path, 0777, true);
        }
        file_put_contents(app_path("/Http/Resources/{$menu}/{$name}.php"), $modelTemplate);
    }

    protected function resourceCollection($name, $menu)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}', '{{menu}}'],
            [$name, $menu],
            $this->getStub('ResourceCollection')
        );
        if (!file_exists($path = app_path("/Http/Resources/{$menu}"))) {
            mkdir($path, 0777, true);
        }
        file_put_contents(app_path("/Http/Resources/{$menu}/{$name}Collection.php"), $modelTemplate);
    }

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
        $name = $this->argument('name');
        $menu = $this->argument('menu');

        $this->resource($name, $menu);
        $this->resourceCollection($name, $menu);
    }
}
