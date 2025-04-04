### Установка

Добавить `"./vendor/4geo35/user-reviews/src/resources/views/components/**/*.blade.php",
        "./vendor/4geo35/user-reviews/src/resources/views/admin/**/*.blade.php",
        "./vendor/4geo35/user-reviews/src/resources/views/livewire/admin/**/*.blade.php",` в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

Добавить `"./vendor/4geo35/contact-page/src/resources/views/components/**/*.blade.php",
"./vendor/4geo35/contact-page/src/resources/views/web/**/*.blade.php", "./vendor/4geo35/contact-page/src/resources/views/livewire/web/**/*.blade.php",` в `tailwind.config.js`, созданный в пакете `tailwindcss-theme`.

Запустить миграции для создания таблиц `php artisan migrate`

### Вывод

Есть страница с отзывами. Для изменения нужно переопределить шаблоны.

Что бы добавить отзывы к другой модели, нужно:

Дописать в конфигурацию описание модели:
 
    "models" => [
       "examples" => [
           "title" => "Example", // Название кнопки в админке
           "searchBy" => "title", // По какому полю искать модель и выводить название
           "class" => \App\Models\Example::class, // Класс модели
       ],
    ],

Модель должна описывать интерфейс `ShouldReviewsInterface`, все есть в трейте `ShouldReviews`, кроме аттрибута `getAdminUrlAttribute`, он нужен для вывода ссылки на страницу модели в админке

На странице модели добавить два компонента:

    <livewire:ur-web-review-list :model="$example" />
    @push("modals")
        <livewire:ur-web-review-form :model="$example" />
    @endpush

Еще нужна кнопка для вызова формы, она должна тригерить событие:

    <button type="button" class="btn btn-primary" x-data @click="$dispatch('show-review-form')">
        Оставить отзыв
    </button>
