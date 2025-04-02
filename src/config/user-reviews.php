<?php

return [
    // Settings
    "webPageUrl" => "reviews",
    "useBreadcrumbs" => true,
    "useH1" => true,
    "reviewNotificationEmails" => env("USER_REVIEW_NOTIFICATION_EMAILS"),

    // Controllers
    "customWebReviewController" => null,
    "customAdminReviewController" => null,

    // Models
    "customReviewModel" => null,

    // Observers
    "customReviewModelObserver" => null,

    // Livewire
    "customWebReviewFormComponent" => null,
    "customWebReviewListComponent" => null,

    // Policy
    "reviewPolicyTitle" => "Управление отзывами",
    "reviewPolicyKey" => "reviews",
    "reviewPolicy" => \GIS\UserReviews\Policies\ReviewPolicy::class,
];
