<?php

namespace GIS\UserReviews\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ShouldReviewsInterface
{
    public function reviews(): MorphMany;

    public function clearReviews(): void;
}
