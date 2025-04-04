<?php

namespace GIS\UserReviews\Livewire\Admin\Reviews;

use GIS\UserReviews\Interfaces\ReviewInterface;
use GIS\UserReviews\Traits\ReviewEditActions;
use Illuminate\View\View;
use Livewire\Component;

class ShowWire extends Component
{
    use ReviewEditActions;

    public ReviewInterface $review;

    public string $morphSearchBy = "title";

    public function mount(): void
    {
        if ($this->review->reviewable) {
            $modelList = config("user-reviews.models");
            foreach ($modelList as $item) {
                if ($item["class"] == $this->review->reviewable::class) {
                    if (! empty($item["searchBy"])) { $this->morphSearchBy = $item["searchBy"]; }
                }
            }
        }
    }

    public function render(): View
    {
        debugbar()->info($this->review);
        return view('ur::livewire.admin.reviews.show-wire');
    }
}
