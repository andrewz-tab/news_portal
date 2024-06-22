@extends('layouts.adminpanel')
@section('content')
    <h1>Добавление разрешения</h1>

    <div class="container col-md-7">
        <form action="{{ route('admin.permissions.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название разрешения</label>
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
