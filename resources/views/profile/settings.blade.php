@extends('layouts.app')
@section('content')
    <!--Change main attributes-->
    <div class="col-md-5">
        <h2>Основные данные:</h2>
        <form action="{{route('profile.general.update')}}" method="POST">
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
            <div class="mb-3">
                <label for="email" class="form-label">Электронная почта</label>
                <input type="text" name="email" class="form-control" id="email" placeholder="example@mail.com"
                       value="{{$user->email}}">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- <div class="mb-3">
                <label for="full_name" class="form-label">Фамилия и имя (не обязательно)</label>
                <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Псевдоним автора"
                       value="{{$user->full_name}}" title="Может понадобиться для того, чтобы стать автором">
                @error('full_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div> --}}
            <button type="submit" class="btn btn-success">Сохранить данные</button>
        </form>

    </div>

    <br/>

    <div class="col-md-7">
        <h1>Смена пароля:</h1>
        <form action="{{route('profile.password.update')}}" method="POST">
            @csrf
            @method('patch')
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label for="oldPasswordInput" class="form-label">Текущий пароль</label>
                    <input name="old_password" type="password"
                           class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                           placeholder="Текущий пароль">
                    @error('old_password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="newPasswordInput" class="form-label">Новый пароль</label>
                    <input name="new_password" type="password"
                           class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                           placeholder="Новый пароль">
                    @error('new_password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="confirmNewPasswordInput" class="form-label">Подтвердите новый пароль</label>
                    <input name="new_password_confirmation" type="password" class="form-control"
                           id="confirmNewPasswordInput"
                           placeholder="Подтвердите новый пароль">
                </div>



            <div class="card-footer">
                <button class="btn btn-success">Сменить пароль</button>
            </div>

        </form>
    </div>
@endsection
