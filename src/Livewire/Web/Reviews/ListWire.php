<?php

namespace GIS\UserReviews\Livewire\Web\Reviews;

use GIS\UserReviews\Interfaces\ShouldReviewsInterface;
use GIS\UserReviews\Models\Review;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ListWire extends Component
{
    use WithPagination;

    public ShouldReviewsInterface|null $model = null;

    public function render(): View
    {
        if ($this->model) {
            $query = $this->model->reviews();
        } else {
            $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
            $query = $reviewModelClass::query();
        }

        $query->with(["images" => function ($query) {
                $query->orderBy("priority");
            }, "answers" => function ($query) {
                $query
                    ->whereNotNull("published_at")
                    ->with(["images" => function ($query) {
                        $query->orderBy("priority");
                    }])
                    ->orderBy("registered_at", "DESC");
            }]);

        if (! $this->model) {
            $query->whereNull("reviewable_id")
                ->whereNull("reviewable_type");
        }

        $query->whereNull("review_id")
            ->whereNotNull("published_at")
            ->orderBy("registered_at", "DESC");

        $reviews = $query->paginate();
        return view('ur::livewire.web.reviews.list-wire', compact('reviews'));
    }

    #[On("review-not-found")]
    public function fireError(): void
    {
        $this->resetPage();
        session()->flash('review-list-error', "Невозможно оставить ответ на отзыв. Такого отзыва не существует, либо он был удален.");
    }
}
