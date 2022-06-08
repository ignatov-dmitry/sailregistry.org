@extends('layouts.admin')

@section('title', 'Типы сертификатов')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Типы сертификатов</h3>
                <div class="card-tools flex">
                    <a href="{{ route('admin.certificates.create') }}" class="btn btn-link">Добавить сертификат</a>
                    <form method="get" class="flex">
                        <input type="text" class="form-control search" value="{{ request('search') }}" placeholder="Поиск" name="search">
                        <button type="submit" class="btn btn-default">Искать</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-responsive-stack mb-3" id="tableOne">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Код</th>
                        <th>Родительский сертификат</th>
                        <th>Приоритет</th>
                        <th>Группа</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($certificates as $certificate)
                        <tr>
                            <td>{{ $certificate->id }}</td>
                            <td>{{ $certificate->name }}</td>
                            <td>{{ $certificate->code }}</td>
                            <td>{{ @$certificate->parent->name }}</td>
                            <td>{{ $certificate->priority }}</td>
                            <td>{{ $certificate->group }}</td>
                            <td>
                                <div class="d-flex flex-row">
{{--                                    <a href="{{ route('admin.certificates.show', $certificate) }}" class="btn btn-sm btn-outline-primary mr-1"><span class="fa fa-tv"></span></a>--}}
                                    <a href="{{ route('admin.certificates.edit', $certificate) }}" class="btn btn-sm btn-outline-primary mr-1"><span class="fa fa-pen"></span></a>
{{--                                    <div class="btn-group">--}}
{{--                                        <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">--}}
{{--                                            <span class="fa fa-trash"></span>--}}
{{--                                        </button>--}}
{{--                                        <div class="dropdown-menu" role="menu" style="">--}}
{{--                                            <a class="dropdown-item">Уверен?</a>--}}
{{--                                            <div class="dropdown-divider"></div>--}}
{{--                                            <a class="dropdown-item" href="{{ route('admin.certificates.destroy', $certificate) }}" class="btn btn-sm btn-outline-danger mr-1">Да</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$certificates->links()}}
            </div>
        </div>
    </section>
@endsection
