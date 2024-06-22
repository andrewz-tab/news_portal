@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>{{$comment->post->title}}</h1>
        @can('update', $comment)
            <form action="{{route('comments.update', $comment->id)}}" method="post">
                @csrf
                @method('patch')
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="text" class="form-label">Редактирование комментария</label>
                        <textarea name="text" class="form-control" id="text" rows="3"
                                  placeholder="Оставить комментарий">{{$comment->text}}
                        </textarea>
                        @error('text')
                        <p>{{$message}}</p>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary ">Обновить комментарий</button>
            </form>
        @endcan
    </div>
@endsection
