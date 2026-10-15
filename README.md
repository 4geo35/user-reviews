### Установка

Добавить в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/user-reviews/src/resources/views/components/**/*.blade.php",
    "./vendor/4geo35/user-reviews/src/resources/views/admin/**/*.blade.php",
    "./vendor/4geo35/user-reviews/src/resources/views/livewire/admin/**/*.blade.php",

Добавить в `tailwind.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/user-reviews/src/resources/views/components/**/*.blade.php",
    "./vendor/4geo35/user-reviews/src/resources/views/web/**/*.blade.php",
    "./vendor/4geo35/user-reviews/src/resources/views/livewire/web/**/*.blade.php",

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

#### Views

Сокращение для представлений: `ur`  
Меню для панели администрирования: `<x-ur::menu-item/>`  

#### Config

Название файла: `user-reviews`

- `webPageUrl` => `reviews`
- `useBreadcrumbs` => `true`
- `useH1` => `true`
- `reviewNotificationEmails` => `env("USER_REVIEW_NOTIFICATION_EMAILS")`
- `models` => [],
