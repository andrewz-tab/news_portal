@extends('layouts.adminpanel')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Редактировать новость</h1>
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
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Новости</li>
                        <li class="breadcrumb-item active">Редактирвание новости</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container">
        <form action="{{route('admin.posts.update', $post->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row mb-3">
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
            <div class="row mb-3">
                <label for="content" class="form-label">Текст к статье</label>
                <textarea id="summernote" name="content" class="form-control" id="content" rows="3">{{$post->content}}</textarea>
                @error('content')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary ">Обновить статью</button>
        </form>
    </div>
@endsection
