<?php

namespace Mzshovon\AutoRepo;

use Illuminate\Support\ServiceProvider;
use Mzshovon\AutoRepo\Command\RepoGenerate;

class RepositoryServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // command auto-discovery
        $this->commands(
            RepoGenerate::class
        );

        // config publish
        $this->publishes([
            __DIR__.'/config/repo-template.php' => config_path('repo-template.php'),
        ], 'repo-template');

        $this->publishes([
            __DIR__.'/config/bind-repository.php' => config_path('repo-template.php'),
        ], 'repo-template');

    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/repo-template.php', 'repo-template'
        );

        $this->mergeConfigFrom(
            __DIR__.'/config/bind-repository.php', 'bind-repository'
        );
    }

}
