@extends('layouts.admin')

@section('title', 'Пользователи')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Пользователи</h3>
                <div>
                    <form method="get" class="user_filter">
{{--                        <a href="{{ route('admin.schools.create') }}" class="btn btn-link">Добавить пользователя</a>--}}
                        <select multiple name="country_id[]" id="countries">
                            @foreach($countries as $country)
                                <option @if(request()->get('country_id') && in_array($country->id, request()->get('country_id'))) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @role('super-admin', 'co-admin')
                        <select multiple name="school_id[]" id="schools">
                            @foreach($schools as $school)
                                <option @if(request()->get('school_id') && in_array($school->id, request()->get('school_id'))) selected @endif value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                        @endrole
                        <input type="text" class="form-control search" value="{{ request('search') }}" placeholder="Поиск" name="search">
                        <button type="submit" class="btn btn-default">Искать</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="users table table-bordered table-striped table-responsive-stack mb-3" id="tableOne">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Имя</th>
                        <th>Страна</th>
                        <th>Дата рождени</th>
                        <th>Фото</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ @$user->country }}</td>
                            <td>{{ $user->birthday }}</td>
                            <td><img class="logo" src="{{ $user->img_src }}" alt=""></td>
                            <td>
                                <div class="d-flex flex-row">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary mr-1" target="_blank"><span class="fa fa-tv"></span></a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary mr-1"><span class="fa fa-pen"></span></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$users->appends(request()->all())->links()}}
            </div>
        </div>
    </section>
@endsection
