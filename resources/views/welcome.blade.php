@extends('layouts.main')

@section('content')
    <div class="onepost slim-top-padding">
        <h3>Good work!</h3>
    </div>
@endsection

@section('seo')
    <title>Сайт о ремонте и уходе за автомобилями и мотоциклами - {{config('app.name')}}</title>
    <meta property="twitter:title" content="Сайт о ремонте и уходе за автомобилями и мотоциклами - {{config('app.name')}}">
    <meta property="twitter:url" content="http://localhost:3000/">
    <meta property="og:url" content="http://localhost:3000/">
    <meta name="description" content="Советы по ремонту и уходу за автомобилями и мотоциклами. Рекомендации для новичков. Правовая и полезная информация для автолюбителей.">
    <meta property="twitter:description" content="Советы по ремонту и уходу за автомобилями и мотоциклами. Рекомендации для новичков. Правовая и полезная информация для автолюбителей.">
    <meta property="og:description" content="Советы по ремонту и уходу за автомобилями и мотоциклами. Рекомендации для новичков. Правовая и полезная информация для автолюбителей.">
    <meta property="og:title" content="Сайт о ремонте и уходе за автомобилями и мотоциклами - {{config('app.name')}}">
@endsection