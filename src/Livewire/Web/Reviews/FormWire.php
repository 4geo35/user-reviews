<?php

namespace GIS\UserReviews\Livewire\Web\Reviews;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class FormWire extends Component
{
    use WithFileUploads;

    public bool $displayForm = false;

    public string $name = '';
    public string $comment = '';
    public array $images = [];

    public bool $hasImageErrors = false;

    public function updatedImages(): void
    {
        $this->hasImageErrors = true;
        $this->validate([
            "images.*" => ["image", "mimes:jpeg,png,jpg", "max:2048"],
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

    protected function resetFields(): void
    {
        $this->reset("name", "comment");
    }
}
