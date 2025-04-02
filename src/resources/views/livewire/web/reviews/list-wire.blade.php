<div>
    <div class="space-y-indent-half mb-indent">
        <x-tt::notifications.error prefix="review-list-" />
        <x-tt::notifications.success prefix="review-list-" />

        @foreach($reviews as $review)
            <x-ur::review.teaser :review="$review" />
        @endforeach
    </div>

    @if ($reviews->hasPages())
        <div class="flex justify-end">
            {{ $reviews->links("tt::pagination.web-live") }}
        </div>
    @endif
</div>
