@extends('layouts.app')
@section('content')
    <div class="row align-content-center">
        <div class="col"></div>
        <div class="col">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="col"></div>
    </div>
    <hr/>
    <div class="row">

        <div class="col-md-7">
            <h1>Профиль</h1>
            <h3>Имя: {{$user->name}} {{$user->full_name != null ? '('.$user->full_name  .')': ''}}</h3>
            <h3>Почта: {{$user->email}}</h3>
            <h6>Зарегистрирован {{date('d.m.Y',$user->created_at->timestamp)}}</h6>
        </div>
        <div class="col-md-auto">
            <!--Settings-->
            <div class="row">
                <a class="btn btn-secondary btn-lg" href="{{route('profile.settings')}}">
                    <i class="bi bi-gear"></i> Редактировать профиль
                </a>
            </div>
            <br/>
            <!--Become an author-->
            @can('create', \App\Models\CV::class)
                <div class="row">
                    <a class="btn btn-secondary btn-lg" href="{{route('cvs.create')}}">
                        <i class="bi bi-pen"></i> Стать автором
                    </a>
                </div>
            @else
                <div class="row">
                    @if(auth()->user()->hasRole('author'))
                        <div class="row">
                            <a class="btn btn-secondary btn-lg" href="{{route('author.panel')}}">
                                <i class="bi bi-pen"></i> Инструменты автора
                            </a>
                        </div>
                    @elseif(auth()->user()->hasCV())
                        <p>Статус
                            заявки: {{auth()->user()->authorStatus() == \App\Models\CV::UNVERIFIED ? 'непроверено' : 'отказано'}} </p>
                    @endif
                </div>
            @endcan
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col">
            <h2>Подписки:</h2>
            @foreach($user->subscriptions as $author)
                <p><a>{{$author->full_name}}</a></p>
            @endforeach
        </div>

        <div class="col">
            <h2>Понравившееся:</h2>
            @foreach($user->favourites as $post)
                <p><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></p>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a class="btn btn-secondary" href="{{route('profile.subscriptions')}}">Посмотреть все</a>
        </div>
        <div class="col">
            <a class="btn btn-secondary" href="{{route('profile.favourites')}}">Посмотреть все</a>
        </div>
    </div>
@endsection
