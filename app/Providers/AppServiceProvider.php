<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCustomBindinds();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    protected function registerCustomBindinds()
    {
        $this->app->bind(
            \App\Models\Api\AnnouncementInterface::class,
            \App\Models\Data\AnnouncementData::class
        );
    }
}
