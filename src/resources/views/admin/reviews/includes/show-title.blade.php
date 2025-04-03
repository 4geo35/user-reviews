<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h2 class="font-medium text-2xl text-nowrap mr-indent-half">
        {{ $review->name }}
    </h2>

    <div class="flex justify-end">
        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                @cannot("update", $review) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showEdit({{ $review->id }})">
            <x-tt::ico.edit />
        </button>
        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                @cannot("delete", $review) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showDelete({{ $review->id }})">
            <x-tt::ico.trash />
        </button>

        <button type="button" class="btn {{ $review->published_at ? 'btn-success' : 'btn-danger' }} px-btn-x-ico ml-indent-half"
                @cannot("update", $review) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="switchPublish({{ $review->id }})">
            @if ($review->published_at)
                <x-tt::ico.toggle-on />
            @else
                <x-tt::ico.toggle-off />
            @endif
        </button>
    </div>
</div>
