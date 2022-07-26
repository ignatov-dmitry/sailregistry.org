@extends('layouts.admin')

@section('title', Route::is('admin.users.edit') ? 'Редактировать: ' . $user->name : 'Добавить пользователя')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ Route::is('admin.users.edit') ? 'Редактировать: ' . $user->user_login : 'Добавить пользователя' }}</h3>

                <div class="card-tools">
                    @if(Route::is('admin.users.edit'))
                        @if($user->old_id)
                            <a href="{{ route('redirectToIytnet', $user->old_id) }}" rel="noreferrer" target="_blank">Посмотреть на iytnet</a>
                        @endif
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-link" target="_blank">Перейти к профилю</a>
                    @endif
                    <a href="{{ route('admin.users.create') }}" class="btn btn-link">Добавить пользователя</a>
                </div>
            </div>
            <div class="card-body">
                {!! Form::open(['url' => Route::is('admin.users.edit') ? route('admin.users.update', $user) : route('admin.users.store'), 'enctype' => 'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('last_name', 'Фамилия', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'last_name', old('last_name', @$user->last_name), ['class' => 'form-control', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('first_name', 'Имя', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'first_name', old('first_name', @$user->first_name), ['class' => 'form-control', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('middle_name', 'Отчество', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'middle_name', old('middle_name', @$user->middle_name), ['class' => 'form-control', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('full_name', 'Полное имя', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'full_name', old('full_name', @$user->full_name), ['class' => 'form-control', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('user_login', 'Логин', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'user_login', old('user_login', @$user->user_login), ['class' => 'form-control', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('country_id', 'Страна', ['class' => 'col-form-label']); !!}
                            {!! Form::select('country_id', $countries, old('country_id', @$user->country_id), [@$canEdit]) !!}
                        </div>
                    </div>
                    @role('super-admin')
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label($schoolSelectAttributes['id'], 'Школа', ['class' => 'col-form-label']); !!}
                            {!! Form::select('school_id[]', $schools, @$userSchoolsIds, $schoolSelectAttributes) !!}
                        </div>
                    </div>
                    @endrole
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('birthday', 'Дата рождения', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'birthday',  Route::is('admin.users.edit') ? date_format(date_create(old('birthday', @$user->birthday)), 'd.m.Y') : '', ['class' => 'form-control date', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('email', 'EMAIL', ['class' => 'col-form-label']); !!}
                            {!! Form::email('email', old('email', @$user->email), ['class' => 'form-control', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('img', 'Фото', ['class' => 'col-form-label']); !!}
                            <div class="input-group">
                                <div class="custom-file @error('logo') is-invalid @enderror">
                                    {!! Form::file('img', ['class' => 'custom-file-input', @$canEdit]) !!}
                                    {!! Form::label('img', 'Выбрать файл', ['class' => 'custom-file-label']); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <img src="{{ isset($user->img) ? '/' . $user->img : '' }}" id="photo" alt="">
                    </div>
                </div>
                @role('super-admin', 'school-admin')
                <div class="form-group mt-3">
                    {!! Form::button('Сохранить', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                </div>
                @endrole
                {!! Form::close() !!}

                @if( Route::is('admin.users.edit'))
                @role('super-admin', 'school-admin')
                <form action="{{ route('admin.users.send_credentials', $user) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <input class="form-control" type="email" placeholder="email" name="email">
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Отправить логин и пароль</button>
                            </div>
                        </div>
                    </div>
                </form>
                @endrole
                @endif
            </div>
        </div>
    </section>
@endsection
