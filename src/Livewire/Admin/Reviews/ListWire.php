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

    public array $modelList = [];
    public string $currentMorph = "none";
    public string $morphSearchBy = "title";
    public string $searchMorph = "";

    protected function queryString(): array
    {
        return [
            "searchName" => ["as" => "name", "except" => ""],
            "searchFrom" => ["as" => "from", "except" => ""],
            "searchTo" => ["as" => "to", "except" => ""],
            "searchPublished" => ["as" => "published", "except" => "all"],
            "currentMorph" => ["as" => "morph", "except" => "none"],
            "searchMorph" => ["as" => "morphName", "except" => ""],
        ];
    }

    public function mount(): void
    {
        if (! empty(config("user-reviews.models"))) {
            $this->modelList = config("user-reviews.models");
        }
    }

    public function render(): View
    {
        $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
        $query = $reviewModelClass::query()
            ->select("reviews.*")
            ->with("images", "answers", "parent");

        if ($this->currentMorph == "none") {
            $query->whereNull("reviewable_id");
            $query->whereNull("reviewable_type");
        } else {
            $className = $this->modelList[$this->currentMorph]["class"];
            $tableName = app($className)->getTable();
            $query->leftJoin($tableName, "reviews.reviewable_id", "=", $tableName . ".id");
            $query->with("reviewable");
            $query->where("reviewable_type", $className);
            BuilderActions::extendLike($query, $this->searchMorph, $tableName . "." . $this->morphSearchBy);
        }

        BuilderActions::extendLike($query, $this->searchName, "reviews.name");
        BuilderActions::extendDate($query, $this->searchFrom, $this->searchTo, "reviews.registered_at");
        BuilderActions::extendPublished($query, $this->searchPublished, "yes", "no", "reviews.published_at");
        BuilderActions::extendLike($query, $this->searchId, "reviews.id");
        $query->orderBy("reviews.registered_at", "DESC");
        $reviews = $query->paginate();

        return view('ur::livewire.admin.reviews.list-wire', compact('reviews'));
    }

    public function clearSearch(): void
    {
        $this->reset("searchName", "searchFrom", "searchTo", "searchPublished", "searchId", "searchMorph");
        $this->resetPage();
    }

    public function setCurrentMorph(string $morph): void
    {
        if ($this->currentMorph === $morph) { return; }
        if ($morph !== 'none' && empty($this->modelList[$morph])) { return; }
        $this->currentMorph = $morph;
        if (! empty($this->modelList[$morph]["searchBy"])) { $this->morphSearchBy = $this->modelList[$morph]["searchBy"]; }
        else { $this->morphSearchBy = "title"; }
        $this->reset("searchMorph");
    }
}
