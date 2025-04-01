<?php

namespace GIS\UserReviews;

use Illuminate\Support\ServiceProvider;

class UserReviewsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Config
        $this->mergeConfigFrom(__DIR__.'/config/user-reviews.php', 'user-reviews');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/routes/admin.php');
    }

    public function boot(): void
    {
        // Views
        $this->loadViewsFrom(__DIR__ . "/resources/views", "ur");
    }
}
