<?php

namespace GIS\UserReviews\Interfaces;

use ArrayAccess;
use GIS\Fileable\Interfaces\ShouldGalleryInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JsonSerializable;
use Stringable;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Contracts\Support\Jsonable;

interface ReviewInterface extends Arrayable, ArrayAccess, CanBeEscapedWhenCastToString,
    HasBroadcastChannel, Jsonable, JsonSerializable, QueueableEntity, Stringable, UrlRoutable, ShouldGalleryInterface
{
    public function user(): BelongsTo;
}
