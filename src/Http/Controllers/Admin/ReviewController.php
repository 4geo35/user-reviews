<?php

namespace GIS\UserReviews\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\UserReviews\Interfaces\ReviewInterface;
use GIS\UserReviews\Models\Review;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
        Gate::authorize("viewAny", $reviewModelClass);
        return view("ur::admin.reviews.index");
    }

    public function show(ReviewInterface $review): View
    {
        Gate::authorize("viewAny", $review::class);
        return view("ur::admin.reviews.show", compact("review"));
    }
}
