<article class="post">
    <header>
        <div class="header-top flex flex-v-center">
            <x-avatar.link :href="route('user.profile', ['username' => $post['user']['username']])" class="user-avatar-link">
                <x-avatar.image :src="$post['user']['profile']['avatar']" width="200" height="200" class="user-avatar" :alt="$post['user']['username']"></x-avatar.image>
            </x-avatar.link>
            <x-avatar.link :href="route('user.profile', ['username' => $post['user']['username']])" class="margin-h-1 post-author flex flex-v-center">{{ $post['user']['username'] }}</x-avatar.link>
            <x-post.publish class="date-published margin-left-auto flex flex-v-center">{{ $post['date_published'] }}</x-post.publish>
        </div>
        <div class="post-header">
            <div class="post-header-inner">
                <x-post.link :href="route('posts.show', ['slug' => $post['slug']])" class="post-name-link">
                    <x-post.name class="post-name">{{ $post['name'] }}</x-post.name>
                </x-post.link>
                <div class="post-categories">
                    <x-svg.tags />
                    <ul>
                        @foreach($post['categories'] as $category)
                            @if ($loop->last)
                                <x-item>
                                    <x-link :href="route('category.show', ['category' => $category['name']])" class="category-link">{{ $category['displayname'] }}</x-link>
                                </x-item>
                            @else
                                <x-item>
                                    <x-link :href="route('category.show', ['category' => $category['name']])" class="category-link">{{ $category['displayname'] }},</x-link>
                                </x-item>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="post-wrapper">
        <picture>
            <source media="(max-width: 375px)" srcset="{{ $post['image_path'] }}">
            <img src="{{ $post['image_path'] }}" width="500" height="333" alt="{{ $post['name'] }}" class="post-image">
        </picture>
    </div>
    <div class="post-content margin-top-2">
       {!! $post['caption'] !!}
    </div>
    <footer class="post-read-more-wrapper">
        <div class="post-buttons-wrapper">
            <div class="post-buttons">
                <div class="eye-block">
                    <x-svg.eye />
                    <p>{{ $post['views'] }}</p>
                </div>
                <div class="rating-block {{ Auth::check() ? 'rating-auth' : 'rating-guest' }}" title="{{ Auth::check() ? 'Проголосуй за статью' : 'Гости не могут голосовать' }}" data-id="{{ $post['id'] }}">
                    <x-svg.star />
                    <p>{{ $post['rating_count'] }}</p>
                </div>
                <div class="comments-block">
                    <x-svg.comments />
                    <p>{{ $post['comments_count'] }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('posts.show', ['slug' => $post['slug']]) }}" class="post-read-more">{{__('Read more')}}
            <x-svg.arrow />
        </a>
    </footer>
</article>