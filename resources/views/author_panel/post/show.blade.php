@extends('layouts.app')
@section('content')

    <h1>{{ $post->title }}</h1>

    <p><img src="{{ $post->image }}" alt=""></p>
    <p>{{ $post->content }}</p>
    <p><i>{{ $post->author->full_name }}, {{ str_replace('-', '.', substr($post->created_at, 0, 10)) }}</i></p>





    <hr class="border-4 "/>
    <h3>Комментарии:</h3>

    @can('create', App\Http\Model\Comment::class)
        <form action="{{ route('posts.comments.store', $post->id) }}" method="post" class="row g-3">
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



    @foreach ($post->comments()->withTrashed()->get() as $comment)
        <hr class="border-1 "/>
        @if($comment->deleted_at == null)
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
        @else
            <div class="row bg-danger">
                <div class="col-2">
                    {{ $comment->user->name }}
                </div>
                <div class="col">
                    {{ $comment->text }}
                </div>

                <div class="col-3 text-end ">

                    <div class="text-sm-end">
                        Удален {{$comment->deleted_at}}
                    </div>

                </div>
            </div>
        @endif
    @endforeach
    <hr class="border-4 "/>

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
