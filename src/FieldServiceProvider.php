<?php

namespace Sbing\Nova\Images;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('images', __DIR__.'/../dist/js/field.js');
            Nova::style('images', __DIR__.'/../dist/css/field.css');
            Nova::translations(__DIR__.'/../resources/lang/zh_CN.json');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
