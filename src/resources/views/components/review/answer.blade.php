@props(["review"])
<div class="p-indent ml-indent border-l border-stroke border-dotted">
    <div class="flex items-end justify-between pb-indent-half border-b border-stroke">
        <div class="text-xl font-semibold">{{ $review->name }}</div>
        <div class="font-semibold text-body/40">{{ $review->registered_human }}</div>
    </div>
    <div class="prose max-w-none prose-p:my-indent-half prose-p:leading-6">
        {!! $review->markdown !!}
    </div>
    <div class="flex items-end justify-between">
        @if ($review->images->count())
            <div class="flex flex-wrap items-center -mx-2">
                @foreach($review->images as $image)
                    <a href="{{ route('thumb-img', ['filename' => $image->filename, 'template' => 'original']) }}"
                       class="block mx-2 my-2 basis-auto shrink-0" data-fslightbox="lightbox-{{ $review->id }}">
                        <img src="{{ route('thumb-img', ['filename' => $image->filename, 'template' => 'gallery-preview']) }}" alt=""
                             class="rounded-md">
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
