@extends('layouts.adminpanel')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Резюме</h1>
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Новости</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <table class="table table-striped projects">
        <thead>
        <tr>
            <th style="width: 1%">
                Id
            </th>
            <th style="width: 20%">
                Пользователь
            </th>
            <th style="width: 20%">
                Создано
            </th>
            <th style="width: 5%" class="text-center">
                Статус
            </th>
            <th style="width: 20%" class="text-center">
                Рассмотрен
            </th>
            <th style="width: 20%" class="text-center">
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($cvs as $cv)
            <tr>
                <td>
                    {{$cv->id}}
                </td>
                <td>
                    <a>{{$cv->user->name}}</a>
                </td>
                <td>
                    {{$cv->created_at}}
                </td>
                <td class="project-state">
                    @if($cv->status == \App\Models\CV::UNVERIFIED)
                        <span class="badge badge-warning">Не проверено</span>
                    @elseif($cv->status == \App\Models\CV::APPROVED)
                        <span class="badge badge-success">Одобрено</span>
                    @elseif($cv->status == \App\Models\CV::REFUSED)
                        <span class="badge badge-danger">Отказано</span>
                    @endif
                </td>
                <td>
                    <a>{{optional($cv->admin)->full_name}}</a>
                </td>

                <td class="project-actions text-center">

                    <a class="btn btn-primary btn-sm" href="{{route('admin.cvs.show', $cv->id)}}">
                        <i class="fas fa-folder">
                        </i>
                        Открыть
                    </a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{$cvs->withQueryString()->links()}}
    </div>
@endsection
