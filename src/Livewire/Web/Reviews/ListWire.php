<?php

namespace GIS\UserReviews\Livewire\Web\Reviews;

use GIS\UserReviews\Models\Review;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ListWire extends Component
{
    use WithPagination;
    public function render(): View
    {
        $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
        $reviews = $reviewModelClass::query()
            ->with(["images", "answers" => function ($query) {
                $query
                    ->whereNotNull("published_at")
                    ->with("images")
                    ->orderBy("registered_at", "DESC");
            }])
            ->whereNull("review_id")
            ->whereNotNull("published_at")
            ->orderBy("registered_at", "DESC")
            ->paginate();
        return view('ur::livewire.web.reviews.list-wire', compact('reviews'));
    }

    #[On("review-not-found")]
    public function fireError(): void
    {
        $this->resetPage();
        session()->flash('review-list-error', "Невозможно оставить ответ на отзыв. Такого отзыва не существует, либо он был удален.");
    }
}
