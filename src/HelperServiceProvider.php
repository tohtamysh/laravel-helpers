<?php

namespace Tohtamysh\Helper;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('helper', function ($app) {
            return new Helper($app);
        });
    }
}