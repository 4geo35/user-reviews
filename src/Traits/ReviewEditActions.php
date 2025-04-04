<?php

namespace GIS\UserReviews\Traits;

use GIS\UserReviews\Interfaces\ReviewInterface;
use GIS\UserReviews\Models\Review;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Carbon;

trait ReviewEditActions
{
    public bool $displayDelete = false;
    public bool $displayData = false;

    public string $name = "";
    public string $comment = "";
    public string $registeredAt = "";

    public int|null $reviewId = null;

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:255"],
            "comment" => ["required", "string"],
            "registeredAt" => ["required", "date"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "name" => "Имя",
            "comment" => "Комментарий",
            "registeredAt" => "Дата отзыва",
        ];
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
        $this->registeredAt = Carbon::parse($review->registered_at)->format("Y-m-d H:i");
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
        /**
         * @var ReviewInterface $review
         */
        session()->flash("success", "Отзыв успешно обновлен");
        $this->closeData();

        if (method_exists($this, "resetPage")) { $this->resetPage(); }
        if (isset($this->review)) { $this->review = $review; } // Почему-то не обновлял через fresh, я хз
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

        if ($review->answers->count() > 0) {
            session()->flash("error", "Невозможно удалить отзыв, у которого есть ответы");
            $this->closeDelete();
            return;
        }

        try {
            $review->delete();
            session()->flash("success", "Отзыв успешно удален");
        } catch (\Exception $exception) {
            session()->flash("error", "Ошибка при удалении отзыва");
        }
        $this->closeDelete();

        if (method_exists($this, "resetPage")) { $this->resetPage(); }
        else { $this->redirectRoute("admin.reviews.index"); }
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
    }

    protected function resetFields(): void
    {
        $this->reset("reviewId", "name", "comment", "registeredAt");
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
