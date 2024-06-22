@extends('layouts.adminpanel')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-5">
                    <h1>Управление разрешениями</h1>
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
                <div class="col-sm-3">
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
        <form method="GET" action="{{route('admin.permissions.index')}}" class="row">
            <label for="name" class="form-label">Поиск</label>
            <div class="col-6">
                <input type="text" name="name" class="form-control" id="name" value="{{$name}}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Поиск</button>
            </div>
        </form>
        <br />
        <div class="row">
            <div class="col">
                <h2>Список разрешений:</h2>
            </div>
            <div class="col"><a class="btn-success btn" href="{{route('admin.permissions.create')}}">
                    <i class="bi bi-plus-lg"></i>
                    Добавить разрешение
                </a>
            </div>
        </div>
        <br/>
        <table class="table table-striped projects">
            <thead>
            <tr>
                <th style="width: 1%">
                    Id
                </th>
                <th style="width: 20%">
                    Название
                </th>
                <th style="width: 20%">
                    Метка
                </th>
                <th style="width: 10%">
                    Пользователи
                </th>
                <th style="width: 10%">
                    Роли
                </th>
                <th style="width: 20%" class="text-center">
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>
                        {{$permission->id}}
                    </td>
                    <td>
                        {{$permission->name}}
                    </td>
                    <td>
                        {{$permission->slug}}
                    </td>
                    <td>
                        {{$permission->users()->count()}}
                    </td>
                    <td>
                        {{$permission->roles()->count()}}
                    </td>
                    <td class="project-actions text-center">
                        <a class="btn btn-sm btn-primary" href="{{route('admin.permissions.edit', $permission->id)}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Изменить
                        </a>
                        <a class="btn btn-sm btn-danger"
                           href="{{route('permissions.destroy', $permission->id)}}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{$permission->id}}').submit();">
                            <i class="fas fa-trash">
                            </i>
                            Удалить
                        </a>
                        <form id="delete-form-{{$permission->id}}"
                              action="{{route('permissions.destroy', $permission->id)}}"
                              method="POST" class="">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
            @endforeach
            {{$permissions->withQueryString()->links()}}
            </tbody>
        </table>

    </div>
@endsection
