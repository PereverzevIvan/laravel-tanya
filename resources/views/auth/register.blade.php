@extends('base')

@section('title')
Регистрация
@endsection

@section('content')
<h1>Это страница регистрации</h1>

@if ($errors -> any())
    <div class="errors">
        <ul class="errors__list">
            @foreach ($errors -> all() as $error)
                <li class="errors__item">
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/register" method="POST" class="form">
    @csrf
    <div class="form__row">
        <label for="name_input" class="form__label">Name</label>
        <input type="text" class="form__input" name="name_input" id="name_input">
    </div>
    <div class="form__row">
        <label for="email_input" class="form__label">Email</label>
        <input type="email" class="form__input" name="email_input" id="email_input">
    </div>
    <div class="form__row">
        <label for="password_input" class="form__label">Password</label>
        <input type="password" class="form__input" name="password_input" id="password_input">
    </div>

    <button class="form__submit" type="submit">Отправить</button>
</form>
@endsection