@extends('layouts.adminpanel')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Резюме пользователя</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Новости</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container">
        <h3><a class="nav-link" href="{{route('admin.users.show', $cv->user->id)}}">Пользователь: {{$cv->user->name}}</a></h3>
        <p> {{ $cv->content }}</p>
        <h4>Статус:
            @if($cv->status == \App\Models\CV::UNVERIFIED)
                <span class="badge badge-warning">Не проверено</span>
            @elseif($cv->status == \App\Models\CV::APPROVED)
                <span class="badge badge-success">Одобрено</span>
            @elseif($cv->status == \App\Models\CV::REFUSED)
                <span class="badge badge-danger">Отказано</span>
            @endif
        </h4>
        <h4>Создано: {{$cv->created_at}}</h4>
        @if($cv->admin_id != null)
            <p>Рассмотрено {{$cv->admin->full_name}}</p>
        @endif
        @if($cv->status != \App\Models\CV::APPROVED)
        <form action="{{route('admin.cvs.accept', $cv->id)}}" method="POST">
            @csrf
            <button class="btn btn-success" type="submit">Одобрить</button>
        </form>
        @endif
        <br />
        @if($cv->status != \App\Models\CV::REFUSED)
        <form action="{{route('admin.cvs.refuse', $cv->id)}}" method="POST">
            @csrf
            <button class="btn btn-danger" type="submit">Отказать</button>
        </form>
        @endif
    </div>

@endsection
