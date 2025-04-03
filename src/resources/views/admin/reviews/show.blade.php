<x-admin-layout>
    <x-slot name="title">Отзыв {{ $review->name }} ({{ $review->id }})</x-slot>
    <x-slot name="pageTitle">Отзыв {{ $review->name }} ({{ $review->id }})</x-slot>

    <div class="flex flex-col gap-y-indent">
        <livewire:ur-admin-review-show :review="$review" />
        <livewire:fa-images :model="$review" />
    </div>
</x-admin-layout>
