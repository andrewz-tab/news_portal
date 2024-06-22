@extends('layouts.adminpanel')
@section('content')
    <h1>Добавление разрешения для пользователя {{$user->name}}</h1>

    <div class="container col-md-7">
    <form action="{{ route('admin.users.permissions.store', $user->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название разрешения</label>
            <p class="text-sm">Если такая метка уже существует, то примениться уже созданное разрешение, а новое создаваться не будет</p>
            <input type="text" name="name" class="form-control" id="name" placeholder="Название"
                   value="{{old('name')}}">
            @error('name')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary ">Добавить разрешение</button>
    </form>
    </div>
@endsection
