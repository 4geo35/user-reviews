<?php

return [
    // Settings
    "webPageUrl" => "reviews",
    "useBreadcrumbs" => true,
    "useH1" => true,

    // Controllers
    "customWebReviewController" => null,

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
