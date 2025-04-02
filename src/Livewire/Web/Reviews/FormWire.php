<?php

namespace GIS\UserReviews\Livewire\Web\Reviews;

use GIS\Fileable\Events\NewImageEvent;
use GIS\UserReviews\Interfaces\ReviewInterface;
use GIS\UserReviews\Models\Review;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class FormWire extends Component
{
    use WithFileUploads;

    public bool $displayForm = false;

    public string $name = '';
    public string $comment = '';
    public array $images = [];

    public bool $hasImageErrors = false;

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:255"],
            "comment" => ["required", "string"],
            "images.*" => ["nullable", "image", "mimes:jpeg,png,jpg,webp", "max:2048"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "name" => "Ваше имя",
            "comment" => "Комментарий",
            "images.*" => "Изображения",
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

    public function closeForm(): void
    {
        $this->displayForm = false;
    }

    public function resetImages(): void
    {
        $this->reset("images");
    }

    public function store(): void
    {
        $this->validate();
        $reviewModelClass = config("user-reviews.customReviewModel") ?? Review::class;
        $review = $reviewModelClass::create([
            "name" => $this->name,
            "comment" => $this->comment,
        ]);
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
        $this->reset("name", "comment", "images");
    }
}
