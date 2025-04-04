<?php

namespace GIS\UserReviews\Traits;

use GIS\UserReviews\Interfaces\ShouldReviewsInterface;
use GIS\UserReviews\Models\Review;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ShouldReviews
{
    protected static function bootShouldReviews(): void
    {
        static::deleted(function (ShouldReviewsInterface $model) {
            $model->clearReviews();
        });
    }

    public function getReviewModelClassAttribute(): string
    {
        return config("user-reviews.customReviewModel") ?? Review::class;
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany($this->review_model_class, "reviewable");
    }

    public function clearReviews(): void
    {
        foreach ($this->reviews as $review) {
            $review->delete();
        }
    }
}
