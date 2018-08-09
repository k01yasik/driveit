<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SeoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seo')->insert([
            ['route_name' => 'page.home', 'title' => 'Сайт о ремонте и уходе за автомобилями и мотоциклами',
                'description' => 'Советы по ремонту и уходу за автомобилями и мотоциклами. Рекомендации для новичков. Правовая и полезная информация для автолюбителей.',
                'created_at' => Carbon::now(), 'updated_at'=> Carbon::now() ],
            ['route_name' => 'users', 'title' => 'Пользователи', 'description' => 'Публичные пользователи', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now() ],
            ['route_name' => 'page.about', 'title' => 'О сайте', 'description' => 'О сайте', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.friends', 'title' => 'Друзья пользователя', 'description' => 'Друзья пользователя', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.albums.edit', 'title' => 'Редактирование названия альбома', 'description' => 'Редактирование названия альбома', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.settings', 'title' => 'Настройки профиля', 'description' => 'Настройки профиля', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'page.rules', 'title' => 'Правила сайта', 'description' => 'Правила сайта', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'posts.rated', 'title' => 'Лучшие статьи по рейтингу', 'description' => 'Лучшие статьи по рейтингу', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'category.show', 'title' => 'Статьи в категории ', 'description' => 'Статьи в категории ', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.albums.create', 'title' => 'Создание нового альбома', 'description' => 'Создание нового альбома', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'admin.comment.edit', 'title' => 'Редактирование комментария', 'description' => 'Редактирование комментария', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'admin.posts', 'title' => 'Все статьи', 'description' => 'Все статьи', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'admin.posts.edit', 'title' => 'Редактирование статьи', 'description' => 'Редактирование статьи', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.messages', 'title' => 'Сообщения пользователя', 'description' => 'Сообщения пользователя', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'admin.comments', 'title' => 'Все комментарии', 'description' => 'Все комментарии', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'posts.comments', 'title' => 'Лучшие статьи по комментариям', 'description' => 'Лучшие статьи по комментариям', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'admin.posts.create', 'title' => 'Добавление новой статьи', 'description' => 'Добавление новой статьи', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.friend.messages', 'title' => 'Диалог с пользователем', 'description' => 'Диалог с пользователем', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'admin.index', 'title' => 'Административный раздел', 'description' => 'Административный раздел', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.comment.edit', 'title' => 'Редактирование комментария', 'description' => 'Редактирование комментария', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'admin.users', 'title' => 'Все пользователи', 'description' => 'Все пользователи', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'posts.views', 'title' => 'Лучшие статьи по просмотрама', 'description' => 'Лучшие статьи по просмотрам', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.albums.index', 'title' => 'Альбомы пользователя', 'description' => 'Альбомы пользователя', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.albums.show', 'title' => 'Альбом пользователя', 'description' => 'Альбом пользователя', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
            ['route_name' => 'user.profile', 'title' => 'Профиль пользователя', 'description' => 'Профиль пользователя', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()],
        ]);
    }
}