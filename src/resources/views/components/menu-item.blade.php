@can("viewAny", config("user-reviews.customReviewModel") ?? \GIS\UserReviews\Models\Review::class)
    <x-tt::admin-menu.item
        href="{{ route('admin.reviews.index') }}"
        :active="in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ['admin.reviews.index', 'admin.reviews.show'])">
        <x-slot name="ico"><x-ur::ico.reviews /></x-slot>
        Отзывы
    </x-tt::admin-menu.item>
@endcan
