<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить отзыв</x-slot>
    <x-slot name="text">Будет невозможно восстановить отзыв</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">Редактировать отзыв</x-slot>
    <x-slot name="content">
        Hello
    </x-slot>
</x-tt::modal.aside>
