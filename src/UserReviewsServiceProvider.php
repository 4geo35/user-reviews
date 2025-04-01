<?php

namespace GIS\UserReviews;

use GIS\UserReviews\Models\Review;
use GIS\UserReviews\Observers\ReviewObserver;
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

        // Expand config
        $this->expandConfiguration();

        // Observers
        $reviewObserverClass = config("user-reviews.customReviewModelObserver") ?? ReviewObserver::class;
        $reviewModelClass = config("user-reviews.reviewModelClass") ?? Review::class;
        $reviewModelClass::observe($reviewObserverClass);
    }

    protected function expandConfiguration(): void
    {
        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        $permissions[] = [
            "title" => config("user-reviews.reviewPolicyTitle"),
            "key" => config("user-reviews.reviewPolicyKey"),
            "policy" => config("user-reviews.reviewPolicy"),
        ];
        app()->config["user-management.permissions"] = $permissions;
    }
}
