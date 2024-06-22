@extends('layouts.app')
@section('content')
    <div class="row">
        @foreach ($posts as $post)

            <div class="col-md-4 col-sm-5 mb-5">
                <div class="thumbnail">
                    <a href="{{ route('posts.show', $post->id) }}" >
                        <img src="{{ $post->image }}" alt="" class="img-fluid rounded">

                        <div class="caption">
                            <h5>{{ $post->title }}</h5>
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
