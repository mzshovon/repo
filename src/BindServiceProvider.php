<?php

namespace Zaman\Repo;

use Illuminate\Support\ServiceProvider;
use Zaman\Repo\Classes\RepositoryBindingManager;

class BindServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $bindings = (new RepositoryBindingManager)->getBindings();

        if(count($bindings) > 0) {
            foreach ($bindings as $interface => $implementation) {
                $this->app->bind($interface, $implementation);
            }
        }

    }

    public function register()
    {
        // Code here....
    }

}
