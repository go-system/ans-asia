<?php

namespace AnsAsia\Commands;

use Illuminate\Support\ServiceProvider;

class AnsServiceProvider extends ServiceProvider
{

    protected $commands = [
        MakeModule::class,
        ModuleGenerate::class,
        MakeController::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
