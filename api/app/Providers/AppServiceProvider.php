<?php

namespace App\Providers;

use App\Macros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        

        Builder::macro('whereSearchByWords', function (string $search, ...$columns) {
            /** @var \Illuminate\Database\Query\Builder $this */
            return (new Macros\WhereSearchByWords($this, $search, $columns))->execute();
        });
    }
}
