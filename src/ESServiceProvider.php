<?php

namespace Wangzd\ScoutES;

use Laravel\Scout\EngineManager;
use Illuminate\Support\ServiceProvider;
use Wangzd\ScoutES\ESEngine;
use Wangzd\ScoutES\Console\ImportCommand;
use Wangzd\ScoutES\Console\FlushCommand;

class ESServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // 注册命令
        if ($this->app->runningInConsole()) {
            $this->commands([
                ImportCommand::class,
                FlushCommand::class,
            ]);
        }

        resolve(EngineManager::class)->extend('elasticsearch', function ($app) {
            return new ESEngine();
        });

    }

    /**
     * 在容器中注册绑定。
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/laravel-scout-elasticsearch.php', 'scout'
        );
    }
}
