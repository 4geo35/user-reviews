<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить отзыв</x-slot>
    <x-slot name="text">Будет невозможно восстановить отзыв</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.dialog wire:model="displayData">
    <x-slot name="title">Редактировать отзыв</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="update" id="reviewForm" class="space-y-indent-half">
            <div>
                <label for="reviewName" class="inline-block mb-2">
                    Имя <span class="text-danger">*</span>
                </label>
                <input type="text" id="reviewName"
                       class="form-control {{ $errors->has("name") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="name">
                <x-tt::form.error name="name"/>
            </div>

            <div>
                <label for="reviewComment" class="flex justify-start items-center mb-2">
                    Комментарий <span class="text-danger">*</span>
                    @include("tt::admin.description-button", ["id" => "reviewInfoHidden"])
                </label>
                @include("tt::admin.description-info", ["id" => "reviewInfoHidden"])
                <textarea id="reviewComment"
                          class="form-control !min-h-52 {{ $errors->has('comment') ? 'border-danger' : '' }}"
                          rows="10" required
                          wire:model.live="comment">
                        {{ $comment }}
                    </textarea>
                <x-tt::form.error name="comment"/>

                <div class="prose prose-sm mt-indent-half">
                    {!! \Illuminate\Support\Str::markdown($comment) !!}
                </div>
            </div>

            <div>
                <label for="reviewRegistered" class="inline-block mb-2">
                    Дата отзыва <span class="text-danger">*</span>
                </label>
                <input type="datetime-local" id="reviewRegistered"
                       class="form-control {{ $errors->has("registeredAt") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="registeredAt">
                <x-tt::form.error name="registeredAt"/>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="reviewForm" class="btn btn-primary">
                    Обновить
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.dialog>
