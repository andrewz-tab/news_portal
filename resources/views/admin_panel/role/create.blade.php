@extends('layouts.adminpanel')
@section('content')
    <h1>Добавление роли</h1>

    <div class="container col-md-7">
        <form action="{{ route('admin.roles.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название роли</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="User"
                       value="{{old('name')}}">
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary ">Добавить роль</button>
        </form>
    </div>
@endsection
