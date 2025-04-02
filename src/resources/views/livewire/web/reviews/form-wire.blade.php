<x-tt::modal.aside wire:model="displayForm" direction="left">
    <x-slot name="title">
        @if ($reviewId)
            Ответить на отзыв
        @else
            Оставить отзыв
        @endif
    </x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="store" class="space-y-indent-half" id="reviewForm">
            <x-tt::notifications.error prefix="review-form-" />
            <x-tt::notifications.success prefix="review-form-" />
            <div>
                <input type="text" id="reviewName" placeholder="Ваше имя*" aria-label="Ваше имя"
                       class="form-control {{ $errors->has("name") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="name">
                <x-tt::form.error name="name"/>
            </div>

            <div>
                <textarea id="reviewComment" placeholder="Комментарий*" aria-label="Комментарий"
                          class="form-control !min-h-52 {{ $errors->has('comment') ? 'border-danger' : '' }}"
                          rows="10" required
                          wire:model="comment">
                        {{ $comment }}
                    </textarea>
                <x-tt::form.error name="comment"/>
            </div>

            @if (\Illuminate\Support\Facades\Auth::check())
                <div>
                    @php($imageCount = count($images))
                    <label for="reviewImages"
                           class="p-indent-half form-control cursor-pointer {{ $errors->has('images.*') ? 'border-danger' : '' }}">
                        @if ($imageCount)
                            <span>Выбрано {{ $imageCount }} {{ num2word($imageCount, ["изображение", "изображения", "изображений"]) }}</span>
                        @else
                            <span>Выберите изображения</span>
                        @endif
                    </label>
                    @if ($imageCount)
                        <button type="button" class="text-primary font-semibold mt-2 cursor-pointer" wire:click="resetImages">
                            Отменить выбор изображений
                        </button>
                    @endif
                    <input type="file" id="reviewImages" multiple aria-label="Изображения"
                           class="form-control hidden"
                           wire:model.lazy="images">

                    <x-tt::form.error name="images.*"/>
                </div>
            @endif

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-secondary" wire:click="closeForm">Отмена</button>
                <button type="submit" form="reviewForm" class="btn btn-primary"
                        @if ($hasImageErrors) disabled @endif>
                    Оставить отзыв
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
