<?php

namespace GIS\UserReviews\Policies;

use App\Models\User;
use GIS\UserManagement\Facades\PermissionActions;
use GIS\UserManagement\Interfaces\PolicyPermissionInterface;
use GIS\UserReviews\Interfaces\ReviewInterface;

class ReviewPolicy implements PolicyPermissionInterface
{
    const PERMISSION_KEY = "reviews";
    const VIEW_ALL = 2;
    const UPDATE = 4;
    const DELETE = 8;

    public static function getPermissions(): array
    {
        return [
            self::VIEW_ALL => "Просмотр всех",
            self::UPDATE => "Обновление",
            self::DELETE => "Удаление",
        ];
    }

    public static function getDefaults(): int
    {
        return self::VIEW_ALL + self::UPDATE + self::DELETE;
    }

    public function viewAny(User $user): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::VIEW_ALL);
    }

    public function update(User $user, ReviewInterface $review): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::UPDATE);
    }

    public function delete(User $user, ReviewInterface $review): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::DELETE);
    }
}
