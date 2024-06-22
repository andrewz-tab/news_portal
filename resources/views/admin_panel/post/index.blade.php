@extends('layouts.adminpanel')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Новости</h1>
                </div><!-- /.col -->
                <div class="col-sm-3">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Новости</li>
                        <li class="breadcrumb-item active">Список новостей</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form method="GET" action="{{route('admin.posts.index')}}" class="row">
        <label for="search" class="form-label">Поиск</label>
        <div class="col-6">
            <input type="text" name="search" class="form-control" id="search" value="{{$search}}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Поиск</button>
        </div>
    </form>
    <br/>
    <table class="table table-striped projects">
        <thead>
        <tr>
            <th style="width: 1%">
                Id
            </th>
            <th style="width: 20px; overflow: hidden; text-overflow: ellipsis;">
                Заголовок
            </th>
            <th style="width: 15%">
                Автор
            </th>
            <th style="width: 15%">
                Создано
            </th>
            <th style="width: 15%">
                Изменено
            </th>
            <th>
                Лайки
            </th>
            <th style="width: 8%" class="text-center">
                Комментарии
            </th>
            <th style="width: 8%" class="text-center">
                Статус
            </th>
            <th style="width: 40%">
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>
                    {{$post->id}}
                </td>
                <td class="text-truncate">
                    {{$post->title}}
                </td>
                <td>
                    <a href="{{route('admin.users.show', $post->author->id)}}">
                        @if(isset($post->author->full_name))
                            {{$post->author->full_name}}
                        @else
                            Страница автора
                        @endif
                    </a>
                </td>
                <td>
                    {{$post->created_at}}
                </td>
                <td>
                    {{$post->updated_at}}
                </td>
                <td>
                    <a>
                        {{$post->favourites_count()}}
                    </a>
                </td>
                <td>
                    <a>
                        {{$post->comments_count()}}
                    </a>
                </td>
                <td class="project-state">
                    <span
                    @class([
                        'badge',
                        'badge-success' => boolval($post->deleted_at == null),
                        'badge-danger' => !boolval($post->deleted_at == null),
                    ])>
                        {{$post->deleted_at == null? 'Активно':'Удалено'}}
                    </span>
                </td>

                <td class="project-actions text-right">
                    @if($post->deleted_at == null)
                        <a class="btn btn-primary btn-sm" href="{{route('admin.posts.show', $post->id)}}">
                            <i class="fas fa-folder">
                            </i>
                            Открыть
                        </a>
                        <a class="btn btn-info btn-sm" href="{{route('admin.posts.edit', $post->id)}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Изменить
                        </a>
                        <a class="btn btn-danger btn-sm" href="{{route('posts.destroy', $post->id)}}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{$post->id}}').submit();">
                            <i class="fas fa-trash">
                            </i>
                            Удалить
                        </a>
                        <form id="delete-form-{{$post->id}}" action="{{route('posts.destroy', $post->id)}}"
                              method="POST">
                            @csrf
                            @method('delete')
                        </form>
                    @else
                        <a class="btn btn-success btn-sm" href="{{route('posts.restore', $post->id)}}" onclick="event.preventDefault();
                                                     document.getElementById('restore-form-{{$post->id}}').submit();">
                            Восстановить
                        </a>
                        <form id="restore-form-{{$post->id}}" action="{{route('posts.restore', $post->id)}}"
                              method="POST">
                            @csrf
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{$posts->withQueryString()->links()}}
    </div>
@endsection
