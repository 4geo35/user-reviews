<div class="p-indent xl:p-indent-double rounded-base bg-linear-150 from-primary/45 to-primary/25 sticky top-indent mb-indent flex flex-wrap items-end justify-between lg:block">
    <div class="text-body/75 leading-5">
        <div class="text-xl xl:text-2xl font-semibold ">
            Оставьте отзыв <span class="text-nowrap">о нас.</span>
        </div>
        <p class="text-lg xl:text-xl">Мы очень ценим <span class="text-nowrap">Ваше мнение.</span></p>
    </div>
    <button type="button" class="btn btn-primary mt-indent-half" x-data @click="$dispatch('show-review-form')">
        Оставить отзыв
    </button>
</div>
