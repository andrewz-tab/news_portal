@extends('layouts.app')
@section('content')
    <h1>Понравилось:</h1>
    <hr class="border-3" />
    @foreach($posts as $post)
        <div class="row">
            <div class="col-md-8">
                <h4><a class="link" href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></h4>
            </div>
            <div class="col-md-auto">
                <form action="{{route('posts.likes.store', $post->id)}}" method="post" class="col-1">
                    @csrf
                        <!-- don't like -->
                        <button type="submit" class="btn btn-secondary text-nowrap" title="Удалить из понравившегося">
                            <i class="bi bi-x-lg"></i>
                            Не нравится
                        </button>
                </form>
            </div>
        </div>
        <hr />
    @endforeach
    {{$posts->links()}}
@endsection
