@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h1 class="m-0">Управление новостями</h1>
                </div><!-- /.col -->
                <div class="col-sm-4">
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
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    
    <table class="table table-striped projects">
        <thead>
        <tr>
            <th >
                Заголовок
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
            <th >
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>
                    {{$post->title}}
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

                <td class="project-actions text-right">
                    <a class="btn btn-primary btn-sm" href="{{route('posts.show', $post->id)}}">
                        <i class="fas fa-folder">
                        </i>
                        Открыть
                    </a>
                    <a class="btn btn-info btn-sm" href="{{route('posts.edit', $post->id)}}">
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
                    <form id="delete-form-{{$post->id}}" action="{{route('posts.destroy', $post->id)}}" method="POST">
                        @csrf
                        @method('delete')
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{$posts->withQueryString()->links()}}
    </div>
@endsection
