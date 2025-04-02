<?php

namespace GIS\UserReviews\Livewire\Admin\Reviews;

use GIS\TraitsHelpers\Facades\BuilderActions;
use GIS\UserReviews\Interfaces\ReviewInterface;
use GIS\UserReviews\Models\Review;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ListWire extends Component
{
    use WithPagination;

    public ReviewInterface|null $review = null;

    public string $searchName = "";
    public string $searchFrom = "";
    public string $searchTo = "";
    public string $searchPublished = "all";

    public bool $displayDelete = false;
    public bool $displayData = false;
    public bool $displayImages = false;

    public string $name = "";
    public string $comment = "";
    public string $registeredAt = "";

    public int|null $reviewId = null;

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
        if ($this->review) {
            $reviews = collect([$this->review]);
        } else {
            $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
            $query = $reviewModelClass::query()->with("images", "answers", "parent");
            BuilderActions::extendLike($query, $this->searchName, "name");
            BuilderActions::extendDate($query, $this->searchFrom, $this->searchTo);
            BuilderActions::extendPublished($query, $this->searchPublished);
            $query->orderBy("created_at", "DESC");
            $reviews = $query->paginate();
        }
        $review = $this->review;
        return view('ur::livewire.admin.reviews.list-wire', compact('reviews', 'review'));
    }

    public function clearSearch(): void
    {
        $this->reset("searchName", "searchFrom", "searchTo", "searchPublished");
        $this->resetPage();
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showEdit(int $id): void
    {
        $this->resetFields();
        $this->reviewId = $id;
        $review = $this->findModel();
        if (! $review) { return; }
        if (! $this->checkAuth("update", $review)) { return; }

        $this->name = $review->name;
        $this->comment = $review->comment;
        $this->registeredAt = $review->registered_at;
        $this->displayData = true;
    }

    public function update(): void
    {
        $review = $this->findModel();
        if (! $review) { return; }
        if (! $this->checkAuth("update", $review)) { return; }
        $this->validate();

        $review->update([
            "name" => $this->name,
            "comment" => $this->comment,
            "registered_at" => $this->registeredAt,
        ]);
        session()->flash("success", "Отзыв успешно обновлен");
        $this->closeData();
    }

    public function showDelete(int $id): void
    {
        $this->resetFields();
        $this->reviewId = $id;
        $review = $this->findModel();
        if (! $review) { return; }
        if (! $this->checkAuth("delete", $review)) { return; }

        $this->displayDelete = true;
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function confirmDelete(): void
    {
        $review = $this->findModel();
        if (! $review) { return; }
        if (! $this->checkAuth("delete", $review)) { return; }

        $review->delete();
        $this->closeDelete();
        session()->flash("success", "Отзыв успешно удален");
        if ($this->review) {
            $this->redirectRoute("admin.reviews.index");
        }
    }

    public function switchPublish(int $id): void
    {
        $this->resetFields();
        $this->reviewId = $id;
        $review = $this->findModel();
        if (! $review) { return; }
        if (! $this->checkAuth("update", $review)) { return; }

        $review->update([
            "published_at" => $review->published_at ? null : now(),
        ]);
        $this->review?->fresh();
    }

    protected function resetFields(): void
    {
        $this->reset("reviewId", "name", "comment", "registeredAt");
        $this->review?->fresh();
    }

    protected function findModel(): ?ReviewInterface
    {
        $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
        $review = $reviewModelClass::query()->find($this->reviewId);
        if (! $review) {
            session()->flash("error", "Отзыв не найден");
            return null;
        }
        return $review;
    }

    protected function checkAuth(string $action, ReviewInterface $review = null): bool
    {
        try {
            $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
            $this->authorize($action, $review ?? $reviewModelClass::find($this->reviewId));
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
