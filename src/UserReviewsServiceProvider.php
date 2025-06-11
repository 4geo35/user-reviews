<?php

namespace GIS\UserReviews;

use GIS\UserReviews\Interfaces\ReviewInterface;
use GIS\UserReviews\Models\Review;
use GIS\UserReviews\Observers\ReviewObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use GIS\UserReviews\Livewire\Web\Reviews\FormWire as WebFormWire;
use GIS\UserReviews\Livewire\Web\Reviews\ListWire as WebListWire;
use GIS\UserReviews\Livewire\Admin\Reviews\ListWire as AdminListWire;
use GIS\UserReviews\Livewire\Admin\Reviews\ShowWire as AdminShowWire;
use Livewire\Livewire;

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

        // Bindings
        $this->bindInterfaces();
    }

    public function boot(): void
    {
        // Views
        $this->loadViewsFrom(__DIR__ . "/resources/views", "ur");

        // Livewire
        $this->addLivewireComponents();

        // Observers
        $this->observeModels();
        $this->setPolicies();

        // Expand config
        $this->expandConfiguration();
    }

    protected function setPolicies(): void
    {
        Gate::policy(config("user-reviews.customReviewModel") ?? Review::class, config("user-reviews.reviewPolicy"));
    }

    protected function observeModels(): void
    {
        $reviewObserverClass = config("user-reviews.customReviewModelObserver") ?? ReviewObserver::class;
        $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
        $reviewModelClass::observe($reviewObserverClass);
    }

    protected function bindInterfaces(): void
    {
        $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
        $this->app->bind(ReviewInterface::class, $reviewModelClass);
    }

    protected function addLivewireComponents(): void
    {
        $component = config("user-reviews.customWebReviewFormComponent");
        Livewire::component(
            "ur-web-review-form",
            $component ?? WebFormWire::class
        );

        $component = config("user-reviews.customWebReviewListComponent");
        Livewire::component(
            "ur-web-review-list",
            $component ?? WebListWire::class
        );

        $component = config("user-reviews.customAdminReviewListComponent");
        Livewire::component(
            "ur-admin-review-list",
            $component ?? AdminListWire::class
        );

        $component = config("user-reviews.customAdminReviewShowComponent");
        Livewire::component(
            "ur-admin-review-show",
            $component ?? AdminShowWire::class
        );
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
