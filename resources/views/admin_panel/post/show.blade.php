@extends('layouts.adminpanel')
@section('content')
    @php
        $paginateValue = 5;
    @endphp
        <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Просмотр новости</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Новости</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container">
        <h1> {{ $post->title }}</h1>

        <p><img src="{{ url($post->getImageURL())}}" style="max-height: 600px" alt=""></p>
        <p>{!! $post->content !!}</p>
        <p><i>{{ $post->author->full_name }}, {{ str_replace('-', '.', substr($post->created_at, 0, 10)) }}</i></p>

        <!-- Like -->
        <div class="row">
            <p>Понравилось: {{$post->favourites_count()}}</p>
        </div>


        <hr class="border-4 "/>
        <h3>Комментарии:</h3>

        @can('create', App\Http\Model\Comment::class)
            <form action="{{ route('posts.comments.store', $post->id) }}" method="post">
                @csrf
                <div class="row mb-3">
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

                                    <button id="navbarDropdown" class="btn btn-secondary btn-sm "
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdown">
                                        @can('update', $comment)
                                            <a class="dropdown-item"
                                               href="{{ route('admin.comments.edit', $comment->id) }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('comment.edit-form-{{$comment->id}}').submit();">
                                                {{ __('Редактировать') }}<i class="bi bi-pen"></i>
                                            </a>
                                            <form id="comment.edit-form-{{$comment->id}}"
                                                  action="{{route('admin.comments.edit', $comment->id)}}"
                                                  method="get">
                                            </form>
                                        @endcan
                                        @can('delete', $comment)
                                            <a class="dropdown-item"
                                               href="{{ route('comments.destroy', $comment->id) }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('comment.destroy-form-{{$comment->id}}').submit();">
                                                {{ __('Удалить') }} <i class="bi bi-trash"></i>
                                            </a>
                                            <form id="comment.destroy-form-{{$comment->id}}"
                                                  action="{{route('comments.destroy', $comment->id)}}"
                                                  method="post">
                                                @csrf
                                                @method('delete')
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

                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">

                                    <button id="navbarDropdown" class="btn btn-secondary btn-sm "
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdown">
                                        @can('restore', $comment)

                                            <a class="dropdown-item"
                                               href="{{ route('comments.restore', $comment->id) }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('comment.edit-form-{{$comment->id}}').submit();">
                                                {{ __('Востановить') }}
                                            </a>
                                            <form id="comment.edit-form-{{$comment->id}}"
                                                  action="{{route('comments.restore', $comment->id)}}"
                                                  method="POST">
                                                @csrf
                                            </form>
                                        @endcan

                                    </div>
                                </li>
                            </ul>


                            <div class="text-sm-end">
                                Удален {{$comment->deleted_at}}
                            </div>

                        </div>
                    </div>
                @endif
            @endforeach
            {{$post->comments->links()}}
            <hr class="border-4 "/>
        @endif
    </div>
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
