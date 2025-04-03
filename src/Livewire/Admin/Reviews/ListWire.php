<?php

namespace GIS\UserReviews\Livewire\Admin\Reviews;

use GIS\TraitsHelpers\Facades\BuilderActions;
use GIS\UserReviews\Models\Review;
use GIS\UserReviews\Traits\ReviewEditActions;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ListWire extends Component
{
    use WithPagination, ReviewEditActions;

    public string $searchName = "";
    public string $searchFrom = "";
    public string $searchTo = "";
    public string $searchPublished = "all";
    public string $searchId = "";

    protected function queryString(): array
    {
        return [
            "searchName" => ["as" => "name", "except" => ""],
            "searchFrom" => ["as" => "from", "except" => ""],
            "searchTo" => ["as" => "to", "except" => ""],
            "searchPublished" => ["as" => "published", "except" => "all"],
        ];
    }

    public function render(): View
    {
        $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
        $query = $reviewModelClass::query()->with("images", "answers", "parent");
        BuilderActions::extendLike($query, $this->searchName, "name");
        BuilderActions::extendDate($query, $this->searchFrom, $this->searchTo, "registered_at");
        BuilderActions::extendPublished($query, $this->searchPublished);
        BuilderActions::extendLike($query, $this->searchId, "id");
        $query->orderBy("registered_at", "DESC");
        $reviews = $query->paginate();

        return view('ur::livewire.admin.reviews.list-wire', compact('reviews'));
    }

    public function clearSearch(): void
    {
        $this->reset("searchName", "searchFrom", "searchTo", "searchPublished", "searchId");
        $this->resetPage();
    }
}
