<?php

namespace GIS\UserReviews\Observers;

use GIS\UserReviews\Interfaces\ReviewInterface;
use Illuminate\Support\Facades\Auth;

class ReviewObserver
{
    public function creating(ReviewInterface $review): void
    {
        $review->ip_address = request()->ip();
        $review->registered_at = now();
        if (Auth::check()) { $review->user_id = Auth::id(); }
    }
}
