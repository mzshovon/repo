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
    }

    public function register()
    {
        //code ....
    }

}
