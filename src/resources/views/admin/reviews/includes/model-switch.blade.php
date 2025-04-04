@if (! empty($modelList))
    <div class="col w-full mb-indent-half">
        <div class="card">
            <div class="card-body">
                <div class="space-y-indent-half">
                    <div class="flex flex-nowrap items-center overflow-x-auto space-x-indent-half">
                        <button type="button" wire:click="setCurrentMorph('none')"
                                class="btn {{ $currentMorph == 'none' ? 'btn-dark' : 'btn-outline-dark' }}">
                            Страница отзывов
                        </button>
                        @foreach($modelList as $key => $modelData)
                            <button type="button" wire:click="setCurrentMorph('{{ $key }}')"
                                    class="btn {{ $currentMorph == $key ? 'btn-dark' : 'btn-outline-dark' }}">
                                {{ $modelData["title"] }}
                            </button>
                        @endforeach
                    </div>
                    @if ($currentMorph !== "none")
                        <div>
                            <input type="text" class="form-control" wire:model.live="searchMorph" placeholder="Поиск связи">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
