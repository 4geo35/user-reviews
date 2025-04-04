@props(["review"])
<div class="p-indent xl:p-indent-double bg-light/25 rounded-base space-y-indent-half">
    <div class="flex items-end justify-between pb-indent-half border-b border-stroke">
        <div class="text-lg xl:text-xl font-semibold">{{ $review->name }}</div>
        <div class="font-semibold text-body/40">{{ $review->registered_human }}</div>
    </div>

    <div class="prose max-w-none prose-p:my-indent-half prose-p:leading-6">
        {!! $review->markdown !!}
    </div>

    @if ($review->images->count())
        <div class="flex flex-wrap items-center -mx-1">
            @foreach($review->images as $image)
                <a href="{{ route('thumb-img', ['filename' => $image->filename, 'template' => 'original']) }}"
                   class="block mx-1 my-1 basis-auto shrink-0" data-fslightbox="lightbox-{{ $review->id }}">
                    <img src="{{ route('thumb-img', ['filename' => $image->filename, 'template' => 'gallery-preview']) }}" alt=""
                         class="rounded-md">
                </a>
            @endforeach
        </div>
    @endif

    <button type="button" class="btn btn-sm btn-outline-primary mt-indent-half mb-2"
            x-data @click="$dispatch('show-answer-form', { id: {{ $review->id }} })">
        Ответить
    </button>

    @if ($review->answers->count())
        @foreach($review->answers as $answer)
            <x-ur::review.answer :review="$answer" />
        @endforeach
    @endif
</div>
