<?php

namespace BanulaLakwindu\ColumnHelpers;

use BanulaLakwindu\ColumnHelpers\Support\Macros\RegisterMacros;
use Illuminate\Support\ServiceProvider;

class ColumnHelpersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        RegisterMacros::register();
    }

    public function register()
    {
        //
    }
}
