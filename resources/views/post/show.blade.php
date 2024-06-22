@extends('layouts.app')
@section('content')

    @php
        $paginateValue = 5;
    @endphp

    <h1>{{ $post->title }}</h1>
    <p><img src="{{ url($post->getImageURL())}}" style="max-height: 600px" alt=""></p>

    <p>{!! $post->content  !!}</p>
    <p><i> {{$post->author->full_name}}, {{ str_replace('-', '.', substr($post->created_at, 0, 10)) }}</i></p>

    <!-- Like and subscribe -->
    <div class="row">
        @can('create', \App\Models\Favourite::class)
            <form action="{{route('posts.likes.store', $post->id)}}" method="post" class="col-1">
                @csrf
                @if($post->isFavourite(auth()->user()))
                    <!-- don't like -->
                    <button type="submit" class="btn btn-danger fs-4" title="Удалить из понравившегося">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                @else
                    <!-- like -->
                    <button type="submit" class="btn btn-outline-secondary fs-4" title="Добавить в понравившееся">
                        <!-- bi bi-heart-fill -->
                        <i class="bi bi-heart"></i>
                    </button>
                @endif
            </form>
        @else
            <form action="{{route('login')}}" method="GET" class="col-1">
                <!-- like -->
                <button type="submit" class="btn btn-outline-secondary fs-4" title="Подписаться">
                    <!-- bi bi-heart-fill -->
                    <i class="bi bi-heart"></i>
                </button>
            </form>
        @endcan
        @can('create', \App\Models\Subscription::class)
            <form action="{{route('subscribe', $post->author_id)}}" method="post" class="col-5">
                @csrf
                @if($post->author->isSubscribed(auth()->user()))
                    <!-- subscribe -->
                    <button type="submit" class="btn  btn-outline-secondary fs-4" title="Отменить подписку">
                        <i class="bi bi-check-lg"></i>
                        Вы подписаны
                    </button>
                @else
                    <!-- unsubscribe -->
                    <button type="submit" class="btn btn-primary fs-4">
                        <i class="bi bi-plus-lg"></i>
                        Подписаться
                    </button>
                @endif
            </form>
        @else
            <form action="{{route('login')}}" method="GET" class="col-5">
                <!-- unsubscribe -->
                <button type="submit" class="btn btn-primary fs-4">
                    <i class="bi bi-plus-lg"></i>
                    Подписаться
                </button>
            </form>
        @endcan
    </div>


    <hr class="border-4 "/>
    <h3>Комментарии:</h3>

    @can('create', App\Http\Model\Comment::class)
        <form action="{{ route('posts.comments.store', $post->id) }}"
              method="post" class="row g-3">
              @csrf
            <div class="mb-3">
                <label for="text" class="form-label"></label>
                <textarea name="text" class="form-control" id="text" rows="3"
                          placeholder="Оставить комментарий">{{old('text')}}</textarea>
                @error('text')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary ">Отправить</button>
        </form>
    @else
        <p><i>Чтобы оставить свой комментарий необходиом войти в свой аккаунт</i></p>
    @endcan


@if(!$post->comments->isEmpty())
    @foreach ($post->comments as $comment)
        <hr class="border-1 "/>
        <div class="row">
            <div class="col-2">
                {{ $comment->user->name }}
            </div>
            <div class="col">
                {{ $comment->text }}
            </div>

            <div class="col-3 text-end ">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">

                        <button id="navbarDropdown" class="btn btn-secondary btn-sm " data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdown">
                            @can('update', $comment)

                                <a class="dropdown-item" href="{{ route('comments.edit', $comment->id) }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('comment.edit-form').submit();">
                                    {{ __('Редактировать') }}<i class="bi bi-pen"></i>
                                </a>
                                <form id="comment.edit-form" action="{{route('comments.edit', $comment->id)}}"
                                      method="get">
                                    {{--                                <button type="submit" class="btn btn-link btn-sm"><i class="bi bi-pen">Редактировать</i>--}}
                                    {{--                                </button>--}}
                                </form>
                            @endcan


                            @can('delete', $comment)

                                <a class="dropdown-item" href="{{ route('comments.destroy', $comment->id) }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('comment.destroy-form').submit();">
                                    {{ __('Удалить') }} <i class="bi bi-trash"></i>
                                </a>
                                <form id="comment.destroy-form" action="{{route('comments.destroy', $comment->id)}}"
                                      method="post">
                                    @csrf
                                    @method('delete')
                                    {{--                            <button type="submit" class="btn btn-link btn-sm"><i class="bi bi-trash">Удалить</i>--}}
                                    {{--                            </button>--}}
                                </form>

                            @endcan
                        </div>
                    </li>
                </ul>

                <div class="text-sm-end">

                    {{ $comment->created_at }}
                </div>

            </div>
        </div>
    @endforeach
    <hr class="border-4 "/>
    {{$post->comments->links()}}
@endif

    <script>
        document.querySelectorAll("button#navbarDropdown").forEach(e => {
            console.log(e.parentElement);
            li = e.parentElement;
            if (li.querySelector("a") == null) {
                butn = li.firstElementChild;
                li.removeChild(butn);
            }
        });
    </script>
@endsection
