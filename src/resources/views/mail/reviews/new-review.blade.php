<x-mail::message>
# Здравствуйте!

На сайте был зарегистрирован отзыв от **{{ $review->name }}**.

{!! $review->markdown !!}

<x-mail::button :url="$url">
    Просмотр
</x-mail::button>

С уважением,<br>
[{{ config('app.name') }}]({{ config("app.url") }})
</x-mail::message>
