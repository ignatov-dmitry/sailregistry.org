@extends('layouts.admin')

@section('title', 'Школы')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Типы сертификатов</h3>
                <div class="card-tools flex">
                    <a href="{{ route('admin.schools.create') }}" class="btn btn-link">Добавить школу</a>
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
                        <th>Русское название</th>
                        <th>Страна</th>
                        <th>Applicant's name</th>
                        <th>Телефон</th>
                        <th>Email</th>
                        <th>Сайт</th>
                        <th>Адрес</th>
                        <th>Видимость</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schools as $school)
                        @php
                            $active = $school->is_active ? true : false;
                        @endphp
                        <tr class="{{ $active ? : 'table-danger' }}">
                            <td>{{ $school->id }}</td>
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->name_rus }}</td>
                            <td>{{ @$school->country->name }}</td>
                            <td>{{ $school->applicants }}</td>
                            <td>{{ $school->phone }}</td>
                            <td>{{ $school->email }}</td>
                            <td>{{ $school->website }}</td>
                            <td>{{ $school->address }}</td>
                            <td>{{ $active ? 'Включено' : 'Выключено' }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    {{--                                    <a href="{{ route('admin.certificates.show', $certificate) }}" class="btn btn-sm btn-outline-primary mr-1"><span class="fa fa-tv"></span></a>--}}
                                    <a href="{{ route('admin.schools.edit', $school) }}" class="btn btn-sm btn-outline-primary mr-1"><span class="fa fa-pen"></span></a>
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
                {{$schools->appends(request()->all())->links()}}
            </div>
        </div>
    </section>
@endsection
