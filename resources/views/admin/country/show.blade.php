@extends('layouts.admin')

@section('title', Route::is('admin.countries.edit') ? 'Редактировать: ' . $country->name : 'Добавить страну')

@section('content')

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ Route::is('admin.countries.edit') ? 'Редактировать: ' . $country->name : 'Добавить страну' }}</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.countries.create') }}" class="btn btn-link">Добавить школу</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ Route::is('admin.countries.edit') ? route('admin.countries.update', $country) : route('admin.countries.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Название</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $country->name) }}" >
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="is_active" class="col-form-label">Активация</label>
                                <select id="is_active" name="is_active">
                                    <option value="1">Да</option>
                                    <option @if(!$country->is_active) selected @endif value="0">Нет</option>
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
