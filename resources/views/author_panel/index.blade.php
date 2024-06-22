@extends('layouts.app')
@section('content')
    <div class="col-md-5">
        <h1>Инструменты автора</h1>
        <h2>Имя автора: {{$author->name}}</h2>
        <h3><a class="nav-link" href="#">Подписчики: {{$author->subscribers()->count()}} </a></h3>
        <br/>
        <div class="row">
            <a class="btn btn-secondary" href="{{route('posts.create')}}">Создать новость</a>
        </div>
        <br/>
        <div class="row">
            <a class="btn btn-secondary" href="{{route('author.posts.index')}}">Управление новостями</a>
        </div>
    </div>
@endsection
