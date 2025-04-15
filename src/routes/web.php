<?php

use Illuminate\Support\Facades\Route;
use GIS\UserReviews\Http\Controllers\Web\ReviewController;

Route::middleware(["web"])
    ->as("web.reviews.")
    ->group(function () {
        if (! empty(config("user-reviews.webPageUrl"))) {
            $controllerClass = config("user-reviews.customWebReviewController") ?? ReviewController::class;
            Route::get(config("user-reviews.webPageUrl"), [$controllerClass, "page"])->name("page");
        }
    });
