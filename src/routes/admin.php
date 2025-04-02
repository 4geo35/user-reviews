<?php

use Illuminate\Support\Facades\Route;
use GIS\UserReviews\Http\Controllers\Admin\ReviewController;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        Route::prefix("reviews")
            ->as("reviews.")
            ->group(function () {
                $controllerClass = config("user-reviews.customAdminReviewController") ?? ReviewController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
            });
    });
