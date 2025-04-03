@props(["review"])
@if ($review->answers->count())
    <ul>
        @foreach($review->answers as $answer)
            <li>
                <a href="{{ route('admin.reviews.show', ['review' => $answer]) }}"
                   class="text-primary hover:text-primary-hover text-nowrap">
                    Есть ответ от "{{ $answer->name }}" ({{ $answer->id }})
                </a>
            </li>
        @endforeach
    </ul>
@elseif ($review->parent)
    <a href="{{ route('admin.reviews.show', ['review' => $review->parent]) }}"
       class="text-primary hover:text-primary-hover text-nowrap">
        Ответ на отзыв от "{{ $review->parent->name }}" ({{ $review->parent->id }})
    </a>
@else
    <span>-</span>
@endif
