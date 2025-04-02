<div class="row">
    <div class="col w-full">
        <div class="card" x-data="{ showImages: 0 }">
            <div class="card-body">
                <div class="space-y-indent-half">
                    @if (! $review)
                        @include("ur::admin.reviews.includes.search")
                    @endif
                    <x-tt::notifications.error />
                    <x-tt::notifications.success />
                </div>
            </div>

            @include("ur::admin.reviews.includes.table")
            @include("ur::admin.reviews.includes.table-modals")
        </div>
    </div>
</div>
