@extends('base')

@section('title')
Статьи
@endsection

@section('content')
<section class="article-section">
    <h1>{{ $article->name }}</h1>
    <div class="article-card">
        <img class="article-card__image" src='{{ asset("images/{$article->preview_image}") }}' alt="" width="500px">
        <div class="article-card__info">
            <p class="article-card__text">{{ $article->desc }}</p>
            <p class="article-card__date">{{ $article->date }}</p>
        </div>
    </div>
</section>
@endsection