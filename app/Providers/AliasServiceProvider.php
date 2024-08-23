<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        // Get the AliasLoader instance
        $loader = AliasLoader::getInstance();
        
        // Add your aliases
        // $loader->alias('Debugbar', Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
