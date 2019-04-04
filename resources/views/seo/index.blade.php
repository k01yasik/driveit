<title>@isset($seo['title']){{$seo['title']}}@endisset</title>
<meta name="description" content="@isset($seo['description']){{$seo['description']}}@endisset">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="@isset($seo['title']){{$seo['title']}}@endisset">
<meta property="twitter:description" content="@isset($seo['description']){{$seo['description']}}@endisset">
@isset($seo['image'])<meta property="og:image" content="{{ $seo['image'] }}" />@endisset
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="@isset($seo['title']){{$seo['title']}}@endisset">
@isset($seo['type'])<meta property="og:type" content="{{ $seo['type'] }}" />@endisset
<meta property="og:description" content="@isset($seo['description']){{$seo['description']}}@endisset">