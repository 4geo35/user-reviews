<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">ID</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Имя</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Комментарий</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Изображения</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($reviews as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>
                    <div class="prose max-w-none prose-sm">
                        {!! $item->markdown !!}
                    </div>
                </td>
                <td>
                    <span class="text-nowrap">
                        {{ $item->images->count() }} {{ num2word($item->images->count(), ["изображение", "изображения", "изображений"]) }}
                    </span>
                </td>
                <td>
                    <div class="flex items-center justify-center">
                        <button type="button" class="btn btn-primary px-btn-x-ico rounded-e-none"
                                @cannot("update", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                @click="showImages = showImages === {{ $item->id }} ? 0 : {{ $item->id }}">
                            <x-tt::ico.image />
                        </button>
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-none"
                                @cannot("update", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit />
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                @cannot("delete", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash />
                        </button>

                        <button type="button" class="btn {{ $item->published_at ? 'btn-success' : 'btn-danger' }} px-btn-x-ico ml-indent-half"
                                @cannot("update", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="switchPublish({{ $item->id }})">
                            @if ($item->published_at)
                                <x-tt::ico.toggle-on />
                            @else
                                <x-tt::ico.toggle-off />
                            @endif
                        </button>
                    </div>
                </td>
            </tr>
            <tr x-show="showImages === {{ $item->id }}" style="display: none">
                <td colspan="5">
                    <livewire:fa-images :model="$item" no-card-cover wire:key="{{ $item->id }}" />
                </td>
            </tr>
        @endforeach
    </x-slot>
    <x-slot name="caption">
        <div class="flex justify-between">
            <div>{{ __("Total") }}: {{ $reviews->total() }}</div>
            {{ $reviews->links("tt::pagination.live") }}
        </div>
    </x-slot>
</x-tt::table>
