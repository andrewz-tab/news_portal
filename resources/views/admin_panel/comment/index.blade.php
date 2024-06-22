@extends('layouts.adminpanel')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Комментарии</h1>
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Новости</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <table class="table table-striped projects">
        <thead>
        <tr>
            <th style="width: 1%">
                Id
            </th>
            <th style="width: 30%">
                Текст
            </th>
            <th style="width: 10%">
                Автор
            </th>
            <th style="width: 10%">
                Создано
            </th>
            <th style="width: 4%" class="text-center">
                Статус
            </th>
            <th style="width: 4%" class="text-center">
                Новость
            </th>
            <th style="width: 20%">
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td>
                    {{$comment->id}}
                </td>
                <td>
                    {{$comment->text}}
                </td>
                <td>
                    <a>
                        {{$comment->user->name}}
                    </a>
                </td>
                <td>
                    {{$comment->created_at}}
                </td>
                <td class="project-state">
                    <span
                    @class([
                        'badge',
                        'badge-success' => boolval($comment->deleted_at == null),
                        'badge-danger' => !boolval($comment->deleted_at == null),
                    ])>
                        {{$comment->deleted_at == null? 'Активно':'Удалено'}}
                    </span>
                </td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{route('admin.posts.show', $comment->post_id)}}">Перейти</a>
                </td>
                <td class="project-actions text-right">
                    @if($comment->deleted_at == null)
                        <a class="btn btn-info btn-sm" href="{{route('admin.comments.edit', $comment->id)}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Изменить
                        </a>
                        <a class="btn btn-danger btn-sm" href="{{route('comments.destroy', $comment->id)}}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{$comment->id}}').submit();">
                            <i class="fas fa-trash">
                            </i>
                            Удалить
                        </a>
                        <form id="delete-form-{{$comment->id}}" action="{{route('comments.destroy', $comment->id)}}" method="POST">
                            @csrf
                            @method('delete')
                        </form>
                    @else
                        <a class="btn btn-success btn-sm" href="{{route('comments.restore', $comment->id)}}" onclick="event.preventDefault();
                                                     document.getElementById('restore-form-{{$comment->id}}').submit();">
                            Восстановить
                        </a>
                        <form id="restore-form-{{$comment->id}}" action="{{route('comments.restore', $comment->id)}}" method="POST">
                            @csrf
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{$comments->withQueryString()->links()}}
    </div>
@endsection
