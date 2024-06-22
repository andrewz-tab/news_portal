@extends('layouts.adminpanel')
@section('content')
    @php
        $paginateValue = 10;
    @endphp
    <div class="container">
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
                    <a class="btn btn-secondary btn-lg" href="{{route('admin.users.edit', $user->id)}}">
                        <i class="bi bi-gear"></i> Редактировать пользователя
                    </a>
                </div>
                <br/>
                <!--Become an author-->
                <div class="row">
                    @if($user->hasCV())
                        @if($user->authorStatus() == \App\Models\CV::UNVERIFIED)
                            <p><a href="{{route('admin.cvs.show', $user->cv->id)}}">Статус
                                    заявки:<a> Непроверено
                            </p>
                        @elseif($user->authorStatus() == \App\Models\CV::REFUSED)
                            <p><a href="{{route('admin.cvs.show', $user->cv->id)}}">Статус
                                    заявки:<a> Отказано
                            </p>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col">
                <h3>Роли пользователя</h3>
                @foreach($user->roles as $role)
                    <p>{{$role->name}}</p>
                @endforeach
            </div>
            <div class="col">
                <h3>Права пользователя</h3>
                @foreach($user->permissions()->paginate($paginateValue) as $permission)
                    <p>{{$permission->name}}</p>
                @endforeach
                {{$user->permissions()->paginate($paginateValue)->links()}}
            </div>
        </div>

        <div hidden>
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
        </div>
    </div>
@endsection
