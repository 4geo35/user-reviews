<x-admin-layout>
    <x-slot name="title">Отзыв {{ $review->name }} ({{ $review->id }})</x-slot>
    <x-slot name="pageTitle">Отзыв {{ $review->name }} ({{ $review->id }})</x-slot>

    <div class="space-y-indent-half">
        <livewire:fa-images :model="$review" />
    </div>
</x-admin-layout>
