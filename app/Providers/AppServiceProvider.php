<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

public function boot()
    {
        Carbon::setLocale('id');

        Blade::component('components.template-layout', 'template-layout');
        Blade::component('components.template-table', 'template-table');
        Blade::component('components.template-row', 'template-row');
    }
}
