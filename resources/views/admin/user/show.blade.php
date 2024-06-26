@extends('layouts.admin')

@section('title', Route::is('admin.users.edit') ? 'Редактировать: ' . $user->user_login : 'Добавить пользователя')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ Route::is('admin.users.edit') ? 'Редактировать: ' . $user->user_login : 'Добавить пользователя' }}</h3>

                <div class="card-tools">
                    @if(Route::is('admin.users.edit'))
                        @if($user->old_id)
                            <a href="{{ route('redirectToIytnet', $user->old_id) }}" class="btn btn-link" rel="noreferrer" target="_blank">Посмотреть на iytnet</a>
                        @endif
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-link" target="_blank">Перейти к профилю</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                {!! Form::open(['url' => Route::is('admin.users.edit') ? route('admin.users.update', $user) : route('admin.users.store', request()->all()), 'enctype' => 'multipart/form-data', 'id' => 'user_form']) !!}
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('last_name_ru', 'Фамилия (ru)', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'last_name_ru', old('last_name_ru', @$user->last_name_ru), ['class' => 'form-control', 'required', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('first_name_ru', 'Имя (ru)', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'first_name_ru', old('first_name_ru', @$user->first_name_ru), ['class' => 'form-control', 'required', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('middle_name_ru', 'Отчество (ru)', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'middle_name_ru', old('middle_name_ru', @$user->middle_name_ru), ['class' => 'form-control', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('last_name_en', 'Фамилия (en)', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'last_name_en', old('last_name_en', @$user->last_name_en), ['class' => 'form-control', 'placeholder' => 'Заполняется автоматически', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('first_name_en', 'Имя (en)', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'first_name_en', old('first_name_en', @$user->first_name_en), ['class' => 'form-control', 'placeholder' => 'Заполняется автоматически', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('middle_name_en', 'Отчество (en)', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'middle_name_en', old('middle_name_en', @$user->middle_name_en), ['class' => 'form-control', 'placeholder' => 'Заполняется автоматически', 'readonly']) !!}
                        </div>
                    </div>
                    @if(Route::is('admin.users.edit'))
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('full_name', 'Полное имя', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'full_name', old('full_name', @$user->full_name), ['class' => 'form-control', @$canEdit]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('user_login', 'Логин', ['class' => 'col-form-label']); !!}
                            {!! Form::input('text', 'user_login', old('user_login', @$user->user_login), ['class' => $errors->has('email') ? 'form-control  is-invalid' : 'form-control', @$canEdit]) !!}
                        </div>
                        @error('user_login')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('country_id', 'Страна', ['class' => 'col-form-label']); !!}
                            {!! Form::select('country_id', $countries, old('country_id', @$user->country_id), [@$canEdit]) !!}
                        </div>
                        @error('country_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
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
                            {!! Form::email('email', old('email', @$user->email), ['class' => $errors->has('email') ? 'form-control  is-invalid' : 'form-control', @$canEdit]) !!}
                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
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
                    @endif
                </div>
                @role('super-admin', 'school-admin')
                @if(@$similarUsers)
                    <div class="form-group mt-3">
                        {!! Form::button('Сохранить принудительно', ['class' => 'btn btn-primary', 'name' => 'force', 'value' => 1, 'type' => 'submit']) !!}
                    </div>
                @else
                    <div class="form-group mt-3">
                        {!! Form::button('Сохранить', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                    </div>
                @endif
                @endrole
                {!! Form::close() !!}

                @if( Route::is('admin.users.edit'))
                @role('super-admin', 'school-admin')
                <form action="{{ route('admin.users.send_credentials', $user) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <input required value="{{ is_null($user->email) ? '' : $user->email }}" class="form-control" type="email" placeholder="email" name="email">
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

    @if(@$similarUsers)
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Похожие пользователи</h3>
            </div>
            <div class="card-body">
                <table class="users table table-bordered table-striped table-responsive-stack mb-3" id="tableOne">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Имя (ru)</th>
                        <th>Фамилия (ru)</th>
                        <th>Имя (en)</th>
                        <th>Фамилия (en)</th>
                        <th>Страна</th>
                        <th>Дата рождени</th>
                        <th>Школы</th>
                        <th>Фото</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($similarUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class="{{ similarColor($user->first_name_en, old('first_name_en', @$user->first_name_en)) }}"><a target="_blank" href="{{ route('admin.users.edit', $user) }}">{{ $user->first_name_en }}</a></td>
                            <td class="{{ similarColor($user->last_name_en, old('last_name_en', @$user->last_name_en)) }}"><a target="_blank" href="{{ route('admin.users.edit', $user) }}">{{ $user->last_name_en }}</a></td>
                            <td class="{{ similarColor($user->first_name_ru, old('first_name_ru', @$user->first_name_ru)) }}"><a target="_blank" href="{{ route('admin.users.edit', $user) }}">{{ $user->first_name_ru }}</a></td>
                            <td class="{{ similarColor($user->last_name_ru, old('last_name_ru', @$user->last_name_ru)) }}"><a target="_blank" href="{{ route('admin.users.edit', $user) }}">{{ $user->last_name_ru }}</a></td>
                            <td>{{ @$user->country }}</td>
                            <td>{{ $user->birthday }}</td>
                            <td>{{ implode(',', array_column($user->schools->toArray() , 'name')) }}</td>
                            <td>
                                @if(isset($user->img))
                                    <img src="{{ '/' . $user->img }}" id="photo" alt="">
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-row">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary mr-1" target="_blank"><span class="fa fa-tv"></span></a>
                                @if(auth()->user()->hasRole('school-admin'))
                                    <!-- Button trigger modal -->
                                    <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#user_{{ $user->id }}">
                                        <span class="fa fa-plus"></span>
                                    </a>

                                    <!-- Modal -->
                                        {!! Form::open(['url' => route('admin.users.addToSchool', $user), 'id' => 'add_to_school']) !!}
                                        <div class="modal fade" id="user_{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Добавить пользователя в школу</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Добавить пользователя {{ $user->first_name_en }} {{ $user->last_name_en }} ({{ $user->first_name_ru }} {{ $user->last_name_ru }}) в школу {{ auth()->user()->schools[0]->name }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                                        <button type="submit" class="btn btn-primary">Да</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif
@endsection
