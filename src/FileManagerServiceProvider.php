<?php

namespace monirujjaman27\LaravelCodeEditor;

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
            __DIR__ . '/config/filemanager.php', 'filemanager'
        );

        // Register views
        $this->loadViewsFrom(__DIR__.'/Views', 'code-editor');
    }

    /**
     * Bootstrap services.
     */
    public function boot(Router $router): void
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/config/filemanager.php' => config_path('filemanager.php'),
        ], 'filemanager-config');

        // Publish views
        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/file-manager'),
        ], 'filemanager-views');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        // Register middleware
        $router->aliasMiddleware('filemanager.auth', \Mcqselftest\LaravelFileManager\Middleware\Authenticate::class);
    }
}