@extends('layouts.app')
@section('content')
    <h1>Подписки:</h1>
    <hr class="border-3" />
    @foreach($subscriptions as $author)
        <div class="row">
            <div class="col-md-5">
                <h4><a>{{$author->full_name}}</a></h4>
            </div>
            <div class="col-md-auto">
                <form action="{{route('subscribe', $author->id)}}" method="post" >
                @csrf
                    <button type="submit" class="btn  btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                        Отписаться
                    </button>
                </form>
            </div>
        </div>
        <hr />
    @endforeach
    {{$subscriptions->links()}}
@endsection
