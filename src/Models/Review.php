<?php

namespace GIS\UserReviews\Models;

use App\Models\User;
use GIS\Fileable\Traits\ShouldGallery;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldHumanPublishDate;
use GIS\UserReviews\Interfaces\ReviewInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class Review extends Model implements ReviewInterface
{
    use ShouldHumanDate, ShouldHumanPublishDate, ShouldGallery, Notifiable;

    public $fillable = [
        "name",
        "comment",
        "registered_at",
    ];

    public function routeNotificationForMail(Notification $notification): array
    {
        return explode(",", config("user-reviews.reviewNotificationEmails"));
    }

    public function answers(): HasMany
    {
        return $this->hasMany(self::class, "review_id");
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, "review_id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function getMarkdownAttribute(): string
    {
        $comment = $this->comment;
        if (empty($comment)) { return ""; }
        return Str::markdown($comment);
    }

    public function getRegisteredHumanAttribute()
    {
        $value = $this->registered_at;
        if (empty($value)) return $value;
        return date_helper()->format($value, "d.m.Y");
    }
}
