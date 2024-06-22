@extends('layouts.app')
@section('content')
    <form method="GET" action="{{route('posts.index')}}" class="row">
        <label for="search" class="form-label">Поиск</label>
        <div class="col-6">
        <input type="text" name="search" class="form-control" id="search" value="{{$search}}">
        </div>
        <div class="col-auto">
        <button type="submit" class="btn btn-primary">Поиск</button>
        </div>
    </form>
    <br />
    <div class="row">
        @foreach ($posts as $post)

            <div class="col-md-4 col-sm-5 mb-5">
                <div class="thumbnail">
                    <a href="{{ route('posts.show', $post->id) }}">


                        <img src="{{ url($post->getImageURL())}}" alt="" class="img-fluid rounded">

                        <div class="caption">
                            <h5>{{ $post->title }}</h5>
                            <div>Автор: {{ $post->author->full_name}}</div>
                        </div>
                    </a>
                </div>
            </div>

        @endforeach
    </div>
    <div>
        {{$posts->withQueryString()->links()}}
    </div>

@endsection
