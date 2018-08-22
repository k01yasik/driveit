<title>@isset($seo['title']){{$seo['title']}}@endisset - {{config('app.name')}}</title>
<meta name="description" content="@isset($seo['description']){{$seo['description']}}@endisset - {{config('app.name')}}">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="@isset($seo['title']){{$seo['title']}}@endisset - {{config('app.name')}}">
<meta property="twitter:description" content="@isset($seo['description']){{$seo['description']}}@endisset - {{config('app.name')}}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@isset($seo['title']){{$seo['title']}}@endisset - {{config('app.name')}}">
<meta property="og:description" content="@isset($seo['description']){{$seo['description']}}@endisset - {{config('app.name')}}">