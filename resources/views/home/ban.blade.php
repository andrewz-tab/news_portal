@extends('layouts.app')
@section('content')
    <div class="container text-center align-middle">
        <p class="fs-1 text-danger">Вы были заблокированы</p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="button btn-app">
                <a class="btn">
                    {{ __('Выход') }}
                </a>
            </button>
        </form>
    </div>
@endsection
