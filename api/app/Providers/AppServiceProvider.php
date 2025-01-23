<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\CreateUserProfile;
use App\Macros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Event;

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
        // Manually register events
        Event::listen(
            UserRegistered::class,
            CreateUserProfile::class
        );        

        Builder::macro('whereSearchByWords', function (string $search, ...$columns) {
            /** @var \Illuminate\Database\Query\Builder $this */
            return (new Macros\WhereSearchByWords($this, $search, $columns))->execute();
        });
    }
}
