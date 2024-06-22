@extends('layouts.adminpanel')
@section('content')
    @php
        $paginateValue = 10;
    @endphp


        <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1>Редактирование пользователя</h1>
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
                    
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="container">
        <h2>Основные данные:</h2>
        <div class="col-md-5">
            <form action="{{route('users.general.update', $user->id)}}" method="POST">
                @csrf
                @method('patch')
                @if (session('statusG'))
                    <div class="alert alert-success" role="alert">
                        {{ session('statusG') }}
                    </div>
                @elseif (session('errorG'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('errorG') }}
                    </div>
                @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Имя профиля</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Имя"
                           value="{{$user->name}}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <label hidden for="userId"></label>
                <input hidden type="text" name="userId" id="userId" value="{{$user->id}}">
                <div class="mb-3">
                    <label for="email" class="form-label">Электронная почта</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="example@mail.com"
                           value="{{$user->email}}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="full_name" class="form-label">Псеводним автора (не обязательно)</label>
                    <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Псеводним автора"
                           value="{{$user->full_name}}" title="Может понадобиться для того, чтобы стать автором">
                    @error('full_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Сохранить данные</button>
            </form>

        </div>

        <hr/>


        <h2>Роли пользователя:</h2>
        <div class="col-md-5">
            <form action="{{route('users.roles.update', $user->id)}}" method="POST">
                @csrf
                @method('patch')
                <div class="mb-3 form-group">
                    <label for="roles" class="form-label">Выбор ролей</label>
                    <select multiple class="form-control" id="roles" name="roles[]">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}"
                                {{$user->roles()->get()->contains($role)? ' selected ' : ''}}
                            >{{$role->name}}</option>
                        @endforeach
                    </select>
                    @error('roles')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Обновить роли</button>
                </div>
            </form>
        </div>
        <hr/>


        <div class="row">
            <div class="col">
                <h2>Разрешения пользователя:</h2>
            </div>
            <div class="col"><a class="btn-success btn" href="{{route('admin.users.permissions.add', $user->id)}}">
                    <i class="bi bi-plus-lg"></i>
                    Добавить разрешения
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
                <th style="width: 20%" class="text-center">
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($user->permissions($paginateValue)->paginate($paginateValue) as $permission)
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
                    <td class="project-actions text-center" href="#">
                        <a class="btn btn-sm btn-primary">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Изменить
                        </a>
                        <a class="btn btn-sm btn-danger"
                           href="{{route('users.permissions.destroy', [$user->id, $permission->id])}}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{$permission->id}}').submit();">
                            <i class="fas fa-trash">
                            </i>
                            Удалить
                        </a>
                        <form id="delete-form-{{$permission->id}}"
                              action="{{route('users.permissions.destroy', [$user->id, $permission->id])}}"
                              method="POST" class="">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
            @endforeach
            {{$user->permissions()->paginate($paginateValue)->links()}}
            </tbody>
        </table>

    </div>
@endsection
