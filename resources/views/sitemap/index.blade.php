<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://web-rookie.ru</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/auto</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/auto-reviews</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/auto-repairs</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/car-care</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/car-device</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/auto-tips-for-begining</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/moto</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/moto-reviews</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/moto-repairs</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/moto-care</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/law</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/category/helpful</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/goods</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/best-rated</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/best-views</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/best-comments</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/about</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/rules</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/login</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/register</loc>
    </url>
    <url>
        <loc>https://web-rookie.ru/posts</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/2</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/3</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/4</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/5</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/6</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/7</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/8</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/9</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/10</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/11</loc>
    </url>
    <url>
        <loc>{{ config('app.url') }}/posts/page/12</loc>
    </url>
    @foreach($data as $key => $item)
        <url>
            <loc>{{ $item['link'] }}</loc>
        </url>
    @endforeach
</urlset>