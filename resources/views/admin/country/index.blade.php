@extends('layouts.admin')

@section('title', 'Страны')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Страны</h3>
                <div class="card-tools flex">
                    <a href="{{ route('admin.countries.create') }}" class="btn btn-link">Добавить сертификат</a>
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
                        <th>Видимость</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($countries as $country)
                        @php
                            $active = $country->is_active ? true : false;
                        @endphp
                        <tr class="{{ $active ? : 'table-danger' }}">
                            <td>{{ $country->id }}</td>
                            <td>{{ $country->name }}</td>
                            <td>{{ $active ? 'Включено' : 'Выключено' }}</td>

                            <td>
                                <div class="d-flex flex-row">
{{--                                                                        <a href="{{ route('admin.countries.edit', $country) }}" class="btn btn-sm btn-outline-primary mr-1"><span class="fa fa-tv"></span></a>--}}
                                    <a href="{{ route('admin.countries.edit', $country) }}" class="btn btn-sm btn-outline-primary mr-1"><span class="fa fa-pen"></span></a>
                                                                        <div class="btn-group">
                                                                            <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle dropdown-icon" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <span class="fa fa-trash"></span>
                                                                            </button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" role="menu" style="">
                                                                                <a class="dropdown-item">Уверен?</a>
                                                                                <div class="dropdown-divider"></div>
                                                                                <form action="{{ route('admin.countries.destroy', $country) }}" method="post">
                                                                                    @csrf
                                                                                    @method('delete')
                                                                                    <button class="dropdown-item" type="submit">Да</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$countries->appends(request()->all())->links()}}
            </div>
        </div>
    </section>
@endsection
