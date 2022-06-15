@extends('layouts.admin')

@section('title', Route::is('admin.schools.edit') ? 'Редактировать: ' . $school->name : 'Добавить школу')

@section('content')

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ Route::is('admin.schools.edit') ? 'Редактировать: ' . $school->name : 'Добавить школу' }}</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.schools.create') }}" class="btn btn-link">Добавить школу</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ Route::is('admin.schools.edit') ? route('admin.schools.update', $school) : route('admin.schools.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input name="school_id" type="hidden" value="{{ $school->id }}">
                    @method('POST')
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Название (eng)</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $school->name) }}" >
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name_rus" class="col-form-label">Название</label>
                                <input id="name_rus" class="form-control @error('name_rus') is-invalid @enderror" name="name_rus" value="{{ old('name_rus', $school->name_rus) }}" >
                                @error('name_rus')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="country_id" class="col-form-label">Страна</label>
                                <select id="country_id" class=" @error('country_id') is-invalid @enderror" name="country_id" >
                                    <option value="">-</option>
                                    @foreach($countries as $country)
                                        <option @if($school->country_id == $country->id) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
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
                                <label for="applicants" class="col-form-label">Applicants</label>
                                <input id="applicants" class="form-control @error('applicants') is-invalid @enderror" name="applicants" value="{{ old('applicants', $school->applicants) }}" >
                                @error('applicants')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="phone" class="col-form-label">Телефон</label>
                                <input id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $school->phone) }}" >
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="email" class="col-form-label">EMAIL</label>
                                <input id="email" class="form-control @error('email') is-invalid @enderror" name="email" type="email" value="{{ old('email', $school->email) }}" >
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="website" class="col-form-label">Сайт</label>
                                <input id="website" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website', $school->website) }}" >
                                @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="address" class="col-form-label">Адрес</label>
                                <input id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $school->address) }}" >
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="logo" class="col-form-label">Логотип</label>
                                <div class="input-group">
                                    <div class="custom-file @error('logo') is-invalid @enderror">
                                        <input type="file" class="custom-file-input " id="logo" name="logo">
                                        <label class="custom-file-label" for="inputGroupFile01">Выбрать файл</label>
                                    </div>
                                    @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description" class="col-form-label">Описание</label>
                                <textarea id="description" class="form-control" name="description" >{{ old('description', $school->description) }}</textarea>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="is_active" class="col-form-label">Активация</label>
                                <select id="is_active" name="is_active">
                                    <option value="1">Да</option>
                                    <option @if(!$school->is_active) selected @endif value="0">Нет</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="admin_id" class="col-form-label">Администратор школы</label>
                                <select required id="admin_id" name="admin_id">
                                    @isset($admin->user_id)
                                        <option selected value="{{ $admin->user_id }}">{{ $admin->user->user_login }}</option>
                                    @endisset
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
