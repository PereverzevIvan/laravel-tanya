@extends('base')

@section('title')
Статьи
@endsection

@section('content')
<h1>Контакты</h1>
<p>Список контактов:</p>
<ul>
    @foreach($data as $contact)
        <li><p>{{ $contact }}</p></li>
    @endforeach
</ul>

@endsection