<?php

namespace Ravaelles\RScaffold;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
//        $this->commands([Crud::class]);

//        dd(__DIR__ . '/views');
        $this->loadViewsFrom(__DIR__ . '/views', 'laravel5-scaffold');
//        $this->loadViewsFrom(__DIR__ . '/../../views', 'laravel-log-viewer');

        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('crud.php'),
//            __DIR__ . '/../classic-templates' => base_path('resources/views/vendor/crud/classic-templates'),
//            __DIR__ . '/../single-page-templates' => base_path('resources/views/vendor/crud/single-page-templates'),
            ], 'Ravaelles');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->registerScaffoldGenerator();
    }

    /**
     * Register the make:scaffold generator.
     */
    private function registerScaffoldGenerator() {
//        $this->app->singleton('command.larascaf.scaffold', function ($app) {
//            return $app['Ravaelles\Laravel5Scaffold\Commands\ScaffoldMakeCommand'];
//        });
//        $this->commands('command.larascaf.scaffold');
    }

}
