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

    public function render(): View
    {
        return view('ur::livewire.admin.reviews.show-wire');
    }
}
