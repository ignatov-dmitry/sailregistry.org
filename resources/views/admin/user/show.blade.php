@extends('layouts.admin')

@section('title', Route::is('admin.users.edit') ? 'Редактировать: ' . $user->name : 'Добавить пользователя')

@section('content')

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ Route::is('admin.users.edit') ? 'Редактировать: ' . $user->user_login : 'Добавить пользователя' }}</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-link" target="_blank">Перейти к профилю</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ Route::is('admin.schools.edit') ? route('admin.users.update', $user) : route('admin.users.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="user_login" class="col-form-label">Логин</label>
                                <input readonly id="user_login" class="form-control @error('user_login') is-invalid @enderror" name="user_login" value="{{ old('user_login', $user->user_login) }}" >
                                @error('user_login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="first_name" class="col-form-label">Имя</label>
                                <input readonly id="first_name" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $user->first_name) }}" >
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="last_name" class="col-form-label">Фамилия</label>
                                <input readonly id="last_name" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $user->last_name) }}" >
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="middle_name" class="col-form-label">Отчество</label>
                                <input readonly id="middle_name" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" >
                                @error('middle_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="full_name" class="col-form-label">Полное имя</label>
                                <input readonly id="full_name" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name', $user->full_name) }}" >
                                @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="country_id" class="col-form-label">Страна</label>
                                <select disabled id="country_id" class=" @error('country_id') is-invalid @enderror" name="country_id" >
                                    <option value="">-</option>
                                    @foreach($countries as $country)
                                        <option @if($user->country_id == $country->id) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="birthday" class="col-form-label">Дата рождения</label>
                                <input id="birthday"readonly class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ old('birthday', $user->birthday) }}" >
                                @error('birthday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="email" class="col-form-label">EMAIL</label>
                                <input id="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" >
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @role('super-admin', 'school-admin')
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                    @endrole
                </form>
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
            </div>
        </div>
    </section>
@endsection
