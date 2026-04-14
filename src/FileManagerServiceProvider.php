<?php

namespace Monirujjaman27\LaravelCodeEditor;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/config/code-editor.php', 'code-editor'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register views
        $this->loadViewsFrom(__DIR__ . '/Views', 'code-editor');

        // Publish config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/code-editor.php' => config_path('code-editor.php'),
            ], 'code-editor-config');

            // Publish views
            $this->publishes([
                __DIR__ . '/Views' => resource_path('views/vendor/code-editor'),
            ], 'code-editor-views');
        }

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}