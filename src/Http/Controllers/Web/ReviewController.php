<?php

namespace GIS\UserReviews\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GIS\Metable\Facades\MetaActions;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function page(): View
    {
        $metas = MetaActions::renderByPage("reviews");
        return view("ur::web.page", compact('metas'));
    }
}
