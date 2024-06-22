@extends('layouts.app')
@section('content')
    <h1>Редактирование новости</h1>
    <form action="{{route('posts.update', $post->id)}}" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок статьи</label>
            <input type="text" name="title" class="form-control" id="title" value="{{$post->title}}">
            @error('title')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="image" class="form-label">Превью к статье</label>
            <div class="w-50 mb-2">
                <img src="{{$post->getImageURL()}}" class="w-50">
            </div>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="image" class="form-control" id="image"
                           value="{{old('image')}}">
                </div>
            </div>
            @error('image')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Текст к статье</label>
            <textarea id="summernote" name="content" class="form-control" id="content" rows="3">{{$post->content}}</textarea>
            @error('content')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

            <button type="submit" class="btn btn-primary ">Обновить статью</button>

    </form>


@endsection
