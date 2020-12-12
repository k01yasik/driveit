<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta property="twitter:url" content="{{ $url }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
@isset($image)<meta property="og:image" content="{{ $image }}" />@endisset
<meta property="og:url" content="{{ $url }}" />
<meta property="og:title" content="{{ $title }}">
@isset($type)<meta property="og:type" content="{{ $type }}" />@endisset
<meta property="og:description" content="{{ $description }}">