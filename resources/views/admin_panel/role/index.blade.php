@extends('layouts.adminpanel')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1>Управление ролями</h1>
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






    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Список ролей:</h2>
            </div>
            <div class="col"><a class="btn-success btn" href="{{route('admin.roles.create')}}">
                    <i class="bi bi-plus-lg"></i>
                    Добавить роль
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
                    Разрешения
                </th>
                <th style="width: 20%" class="text-center">
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>
                        {{$role->id}}
                    </td>
                    <td>
                        {{$role->name}}
                    </td>
                    <td>
                        {{$role->slug}}
                    </td>
                    <td>
                        {{$role->users()->count()}}
                    </td>
                    <td>
                        {{$role->permissions()->count()}}
                    </td>
                    <td class="project-actions text-center">
                        <a class="btn btn-sm btn-primary" href="{{route('admin.roles.edit', $role->id)}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Изменить
                        </a>
                        <a class="btn btn-sm btn-danger"
                           href="{{route('roles.destroy', $role->id)}}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{$role->id}}').submit();">
                            <i class="fas fa-trash">
                            </i>
                            Удалить
                        </a>
                        <form id="delete-form-{{$role->id}}"
                              action="{{route('roles.destroy', $role->id)}}"
                              method="POST" class="">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
            @endforeach
            {{$roles->links()}}
            </tbody>
        </table>

    </div>
@endsection
