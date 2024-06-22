@extends('layouts.adminpanel')
@section('content')
    <div class="col-sm-7">
        <h1>Управление ролью {{$role->name}}</h1>
    </div><!-- /.col -->
    <div class="row">
        <div class="col-sm-4    "></div>
    <div class="col-sm-5 align-content-centerS">
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
    </div>


    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Пользователи:</h2>
            </div>
        </div>
        <table class="table table-striped projects">
            <thead>
            <tr>
                <th style="width: 1%">
                    Id
                </th>
                <th style="width: 20%">
                    Имя
                </th>
                <th style="width: 20%">
                    Почта
                </th>
                <th style="width: 20%" class="text-center">
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
                    <td class="project-actions text-center">
                        <a class="btn btn-sm btn-primary" href="{{route('admin.users.edit', $user->id)}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Изменить
                        </a>
                        <a class="btn btn-sm btn-danger"
                           href="{{route('users.roles.destroy', [$user->id, $role->id])}}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-user-{{$user->id}}').submit();">
                            <i class="fas fa-trash">
                            </i>
                            Удалить
                        </a>
                        <form id="delete-form-user-{{$user->id}}"
                              action="{{route('users.roles.destroy', [$user->id, $role->id])}}"
                              method="POST" class="">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
            @endforeach
            {{$users->appends(['permissions' => $permissions->currentPage()])->links()}}
            </tbody>
        </table>
        <hr/>

        <div class="row">
            <div class="col">
                <h2>Разрешения роли:</h2>
            </div>
            <div class="col"><a class="btn-success btn" href="{{route('admin.roles.permissions.add', $role->id)}}">
                    <i class="bi bi-plus-lg"></i>
                    Добавить разрешение
                </a>
            </div>
        </div>

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
                    <td class="project-actions text-center">
                        <a class="btn btn-sm btn-primary" href="{{route('admin.permissions.edit', $permission->id)}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Изменить
                        </a>
                        <a class="btn btn-sm btn-danger"
                           href="{{route('roles.permissions.destroy', [$role->id, $permission->id])}}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-permission-{{$permission->id}}').submit();">
                            <i class="fas fa-trash">
                            </i>
                            Удалить
                        </a>
                        <form id="delete-form-permission-{{$permission->id}}"
                              action="{{route('roles.permissions.destroy', [$role->id, $permission->id])}}"
                              method="POST" class="">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
            @endforeach
            {{$permissions->appends(['users' => $users->currentPage()])->links()}}
            </tbody>
        </table>

    </div>
@endsection
