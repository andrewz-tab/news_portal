@extends('layouts.app')
@section('content')
    <form action="{{route('cvs.store')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="full_name" class="form-label">Псевдоним автора</label>
            <input type="text" name="full_name" class="form-control" id="full_name"
                   value="{{auth()->user()->full_name}}">
            @error('full_name')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">О себе</label>
            <textarea name="content" class="form-control" id="content" rows="3">{{old('content')}}</textarea>
            @error('content')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary ">Отправить резюме</button>
    </form>
@endsection
