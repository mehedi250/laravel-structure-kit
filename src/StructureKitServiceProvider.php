<?php

namespace StructureKit;

use Illuminate\Support\ServiceProvider;
use StructureKit\Console\Commands\StructureKitCommand;
use StructureKit\Services\StructureKitService;
use StructureKit\Generators\StructureGenerator;

class StructureKitServiceProvider extends ServiceProvider
{
    /**
     * Register bindings
     */
    public function register(): void
    {
        // Bind generator
        $this->app->singleton(StructureGenerator::class, function () {
            return new StructureGenerator();
        });

        // Bind service
        $this->app->singleton(StructureKitService::class, function ($app) {
            return new StructureKitService(
                $app->make(StructureGenerator::class)
            );
        });
    }

    /**
     * Bootstrap package services
     */
    public function boot(): void
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'structure-kit');

        // Publish views (optional, future)
        $this->publishes([
            __DIR__ . '/Resources/views' => resource_path('views/vendor/structure-kit'),
        ], 'structure-kit-views');

        if ($this->app->runningInConsole()) {
            $this->commands([
                StructureKitCommand::class,
            ]);
        }
    }
}
