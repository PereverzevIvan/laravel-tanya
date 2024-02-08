<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
    <header class="header">
        <a href="/" class="header__logo">
            Политех
        </a>
        <nav class="header__nav">
            <a href="/" class="header__link">Главная</a>
            <a href="/article" class="header__link">Статьи</a>
            @can('create')
                <a href="/article/create" class="header__link">Создание статьи</a>
            @endcan
            @can('comment-admin')
                <a href="/comment/" class="header__link">Все комментарии</a>
            @endcan
            <a href="/contacts" class="header__link">Контакты</a>
            <a href="/about_us" class="header__link">О нас</a>
        </nav>
        @auth
            <div class="dropdown">
                <button class="dropbtn">Новый комментарии ({{ auth()->user()->unreadNotifications->count() }})</button>
                <div class="dropdown-content">
                    @foreach (auth()->user()->unreadNotifications as $notify)
                        <a href="{{ route('article.show', ['article' => $notify->data['article']['id'], 'notify' => $notify->id]) }}" class="header__link">
                            Статья: {{ $notify->data['article']['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endauth
        @if (Auth::user() != null)
        <a href="/logout" class="header__link">{{ Auth::user()->name }}</a>
        @else
            <a href="/register" class="header__link">Регистрация</a>
            <a href="/login" class="header__link">Вход</a>
        @endif
    </header>
    <main class="main">
        @yield('content')
    </main>
    <footer class="footer">
        Ашрафулин Рамиль - 221-321
    </footer>
</body>
</html>

<style>
    /* Dropdown Button */
    .dropbtn {
    background-color: #04AA6D;
    color: white;
    padding: 15px, 10px;
    font-size: 16px;
    border: none;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
    position: relative;
    display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {background-color: #ddd;}

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {display: block;}

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>