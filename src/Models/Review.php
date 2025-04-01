<?php

namespace GIS\UserReviews\Models;

use App\Models\User;
use GIS\Fileable\Traits\ShouldGallery;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldHumanPublishDate;
use GIS\UserReviews\Interfaces\ReviewInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model implements ReviewInterface
{
    use ShouldHumanDate, ShouldHumanPublishDate, ShouldGallery;

    public $fillable = [
        "name",
        "comment",
        "registered_at",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
