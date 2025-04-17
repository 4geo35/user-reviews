<?php

namespace GIS\UserReviews\Livewire\Web\Reviews;

use GIS\Fileable\Events\NewImageEvent;
use GIS\UserReviews\Interfaces\ReviewInterface;
use GIS\UserReviews\Interfaces\ShouldReviewsInterface;
use GIS\UserReviews\Models\Review;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class FormWire extends Component
{
    use WithFileUploads;

    public ShouldReviewsInterface|null $model = null;

    public bool $displayForm = false;

    public string $name = '';
    public string $comment = '';
    public array $images = [];
    public bool $privacy = true;

    public int|null $reviewId = null;

    public bool $hasImageErrors = false;

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:255"],
            "comment" => ["required", "string"],
            "images.*" => ["nullable", "image", "mimes:jpeg,png,jpg,webp", "max:2048"],
            "privacy" => ["required"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "name" => "Ваше имя",
            "comment" => "Комментарий",
            "images.*" => "Изображения",
            "privacy" => "Политика конфиденциальности",
        ];
    }

    public function updatedImages(): void
    {
        $this->hasImageErrors = true;
        $this->validate([
            "images.*" => ["nullable", "image", "mimes:jpeg,png,jpg,webp", "max:2048"],
        ], [], [
            "images.*" => "Изображения"
        ]);
        $this->hasImageErrors = false;
    }

    public function render(): View
    {
        return view('ur::livewire.web.reviews.form-wire');
    }

    #[On("show-review-form")]
    public function showForm(): void
    {
        $this->resetFields();
        $this->displayForm = true;
    }

    #[On("show-answer-form")]
    public function showAnswerForm(int $id): void
    {
        $this->resetFields();
        $this->reviewId = $id;
        $review = $this->findModel();
        if (! $review) { return; }

        $this->displayForm = true;
    }

    public function closeForm(): void
    {
        $this->displayForm = false;
    }

    public function resetImages(): void
    {
        $this->reset("images");
        $this->hasImageErrors = false;
    }

    public function store(): void
    {
        $this->validate();
        $data = [
            "name" => $this->name,
            "comment" => $this->comment,
        ];
        if ($this->reviewId) {
            $reviewParent = $this->findModel();
            if (! $reviewParent) {
                $this->closeForm();
                return;
            }
            $review = $reviewParent->answers()->create($data);
        } else {
            if ($this->model) {
                $review = $this->model->reviews()->create($data);
            } else {
                $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
                $review = $reviewModelClass::create($data);
            }
        }
        $this->addImagesToReview($review);
        session()->flash("review-form-success", "Мы получили Ваше сообщение! Отзыв появится на сайте после проверки модератором.");
        $this->resetFields();
    }

    protected function addImagesToReview(ReviewInterface $review): void
    {
        if (count($this->images)) {
            foreach ($this->images as $image) {
                /**
                 * @var TemporaryUploadedFile $image
                 */
                $clientOriginal = $image->getClientOriginalName();
                $exploded = explode(".", $clientOriginal);
                $review->livewireGalleryImage($image, $exploded[0]);
                NewImageEvent::dispatch($review);
            }
            $review->touch();
        }
    }

    protected function resetFields(): void
    {
        $this->reset("name", "comment", "images", "reviewId", "privacy");
    }

    protected function findModel(): ?ReviewInterface
    {
        $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
        $review = $reviewModelClass::find($this->reviewId);
        if (!$review) {
            $this->dispatch("review-not-found");
            return null;
        }
        return $review;
    }
}
