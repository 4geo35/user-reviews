<?php

namespace GIS\UserReviews\Observers;

use GIS\UserReviews\Interfaces\ReviewInterface;
use GIS\UserReviews\Notifications\NewUserReview;
use Illuminate\Support\Facades\Auth;

class ReviewObserver
{
    public function creating(ReviewInterface $review): void
    {
        $review->ip_address = request()->ip();
        $review->registered_at = now();
        if (Auth::check()) { $review->user_id = Auth::id(); }
        if ($review->review_id) {
            $parent = $review->parent;
            /**
             * @var ReviewInterface $parent
             */
            $review->reviewable_id = $parent->reviewable_id;
            $review->reviewable_type = $parent->reviewable_type;
        }
    }

    public function created(ReviewInterface $review): void
    {
        $notificationClass = config("user-reviews.customReviewModelNotification") ?? NewUserReview::class;
        $review->notify(new $notificationClass);
    }
}
