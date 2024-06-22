@extends('layouts.app')
@section('content')
    <form action="{{ route('posts.store') }}" method="post" class="row g-3" enctype="multipart/form-data">
       @csrf
        <div class="form-group mb-3">
            <label for="title" class="form-label">Заголовок статьи</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Заголовок"
                   value="{{old('title')}}">
            @error('title')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="image" class="form-label">Превью к статье</label>
            <div class="input-group">
                <div class="custom-file">
                    <label class="form-label" for="image">Выберите изображение</label>
                    <input type="file" name="image" class="form-control" id="image"
                           value="{{old('image')}}">
                </div>
            </div>
            @error('image')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="content" class="form-label">Текст к статье</label>
            <textarea id="summernote" name="content" class="form-control" id="content"
                      rows="3">{{old('content')}}</textarea>
            @error('content')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary ">Создать статью</button>
    </form>

  

@endsection
