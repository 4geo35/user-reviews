<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">ID</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Данные</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Комментарий</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Ответы</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($reviews as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between space-x-2">
                            <div class="font-semibold">Имя:</div>
                            <div>{{ $item->name }}</div>
                        </div>
                        <div class="flex items-center justify-between space-x-2">
                            <div class="font-semibold">Изображения:</div>
                            <div>{{ $item->images->count() }}</div>
                        </div>
                        <div class="flex items-center justify-between space-x-2">
                            <div class="font-semibold">Дата:</div>
                            <div>{{ $item->registered_human }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="prose max-w-none prose-sm">
                        {!! $item->markdown !!}
                    </div>
                </td>
                <td>
                    @if ($item->answers->count())
                        <ul>
                            @foreach($item->answers as $answer)
                                <li>
                                    <a href="{{ route('admin.reviews.show', ['review' => $answer]) }}"
                                       class="text-primary hover:text-primary-hover text-nowrap">
                                        Есть ответ от "{{ $answer->name }}" ({{ $answer->id }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @elseif ($item->parent)
                        <a href="{{ route('admin.reviews.show', ['review' => $item->parent]) }}"
                           class="text-primary hover:text-primary-hover text-nowrap">
                            Ответ на отзыв от "{{ $item->parent->name }}" ({{ $item->parent->id }})
                        </a>
                    @else
                        <span>-</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center justify-center">
                        @if (! $review)
                            @can("viewAny", $item::class)
                                <a href="{{ route('admin.reviews.show', ['review' => $item]) }}" class="btn btn-primary px-btn-x-ico rounded-e-none">
                                    <x-tt::ico.eye />
                                </a>
                            @else
                                <button type="button" class="btn btn-primary px-btn-x-ico rounded-e-none" disabled>
                                    <x-tt::ico.eye />
                                </button>
                            @endcan
                        @endif
                        <button type="button" class="btn btn-dark px-btn-x-ico {{ $review ? 'rounded-e-none' : 'rounded-none' }}"
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
        @endforeach
    </x-slot>
    <x-slot name="caption">
        @if (! $review)
            <div class="flex justify-between">
                <div>{{ __("Total") }}: {{ $reviews->total() }}</div>
                {{ $reviews->links("tt::pagination.live") }}
            </div>
        @endif
    </x-slot>
</x-tt::table>
