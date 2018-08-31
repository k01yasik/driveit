<rss
        xmlns:yandex="http://news.yandex.ru"
        xmlns:media="http://search.yahoo.com/mrss/"
        xmlns:turbo="http://turbo.yandex.ru"
        version="2.0">
    <channel>
        @foreach($data as $key => $item)
            <item turbo="true">
                <link>{{ $item['link'] }}</link>
                <turbo:content>
                    <![CDATA[
                        <header>
                            <h1>{{ $item['name'] }}</h1>
                        </header>
                        <img src="{{ $item['image'] }}" />
                        {!! $item['caption'] !!}
                    ]]>
                </turbo:content>
            </item>
        @endforeach
    </channel>
</rss>