@extends('layouts.adminpanel')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Пользователи</h1>
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
            <th style="width: 10%">
                Имя
            </th>
            <th style="width: 15%">
                Почта
            </th>
            <th style="width: 15%">
                Зарегистрирован
            </th>
            <th style="width: 8%" class="text-center">
                Статус
            </th>
            <th >
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>
                    {{$user->id}}
                </td>
                <td>
                    {{$user->name}}
                </td>
                <td>
                    {{$user->email}}
                </td>
                <td>
                    {{$user->created_at}}
                </td>
                <td class="project-state">
                    <span
                    @class([
                        'badge',
                        'badge-success' => !$user->isBanned(),
                        'badge-danger' => $user->isBanned(),
                    ])>
                        {{!$user->isBanned()? 'Активен':'Забанен'}}
                    </span>
                </td>

                <td class="project-actions text-right">

                    <a class="btn btn-primary btn-sm" href="{{route('admin.users.show', $user->id)}}">
                        <i class="fas fa-folder">
                        </i>
                        Открыть
                    </a>
                    <a class="btn btn-info btn-sm" href="{{route('admin.users.edit', $user->id)}}">
                        <i class="fas fa-pencil-alt">
                        </i>
                        Изменить
                    </a>
                    @if($user->isBanned())
                        <a class="btn btn-success btn-sm" href="{{route('admin.users.unban', $user->id)}}"
                           onclick="event.preventDefault(); document.getElementById('unban-form-{{$user->id}}').submit();">
                            Разблокировать
                        </a>
                        <form id="unban-form-{{$user->id}}" action="{{route('admin.users.unban', $user->id)}}" method="POST">
                            @csrf
                        </form>
                    @else
                        <a class="btn btn-danger btn-sm" href="{{route('admin.users.ban', $user->id)}}"
                           onclick="event.preventDefault(); document.getElementById('ban-form-{{$user->id}}').submit();">
                            <i class="bi bi-ban">
                            </i>
                            Заблокировать
                        </a>
                        <form id="ban-form-{{$user->id}}" action="{{route('admin.users.ban', $user->id)}}" method="POST">
                            @csrf
                        </form>
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{$users->withQueryString()->links()}}
    </div>
@endsection
