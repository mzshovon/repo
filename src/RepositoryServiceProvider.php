<?php

namespace Zaman\Repo;

use Illuminate\Support\ServiceProvider;
use Zaman\Repo\Command\RepoGenerate;

class RepositoryServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands(
            RepoGenerate::class
        );
        $this->publishes([
            __DIR__.'/config/repo-template.php' => config_path('repo-template.php'),
        ], 'your-package-config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/repo-template.php', 'repo-template'
        );
    }

}
