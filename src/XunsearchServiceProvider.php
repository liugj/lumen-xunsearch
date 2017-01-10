<?php
namespace Liugj\Xunsearch;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use Laravel\Scout\Console\FlushCommand;
use Laravel\Scout\Console\ImportCommand;
use Liugj\Xunsearch\Engines\XunsearchEngine;

class XunsearchServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->configure('scout');
        $this->app->singleton(EngineManager::class, function ($app) {
                return (new EngineManager($app))->extend('xunsearch', function ($app) {
                        return new XunsearchEngine(new XunsearchClient(
                            config('scout.xunsearch.index'),
                            config('scout.xunsearch.search')
                        ));
                });
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                    ImportCommand::class,
                    FlushCommand::class,
            ]);
        }
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [EngineManager::class];
    }
}
