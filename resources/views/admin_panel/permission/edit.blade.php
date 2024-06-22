@extends('layouts.adminpanel')
@section('content')
    <div class="col-sm-9">
        <h1>Управление разрешенем {{$permission->name}}</h1>
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
                           href="{{route('users.permissions.destroy', [$user->id, $permission->id])}}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-user-{{$user->id}}').submit();">
                            <i class="fas fa-trash">
                            </i>
                            Удалить
                        </a>
                        <form id="delete-form-user-{{$user->id}}"
                              action="{{route('users.permissions.destroy', [$user->id, $permission->id])}}"
                              method="POST" class="">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
            @endforeach
            {{$users->links()}}
            </tbody>
        </table>
        <hr/>


        <h2>Роли, у которых есть разрешение:</h2>
        <div class="col-md-5">
            <form action="{{route('permissions.roles.update', $permission->id)}}" method="POST">
                @csrf
                @method('patch')
                <div class="mb-3 form-group">
                    <label for="roles" class="form-label">Выбор ролей</label>
                    <select multiple class="form-control" id="roles" name="roles[]">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}"
                                {{$permission->roles()->get()->contains($role)? ' selected ' : ''}}
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
    </div>
@endsection
