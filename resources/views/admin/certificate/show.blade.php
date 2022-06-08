@extends('layouts.admin')

@section('title', 'Редактировать ' . $certificateType->name)

@section('content')

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ 'Редактировать ' . $certificateType->name}}</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.certificates.create') }}" class="btn btn-link">Добавить сертификат</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ Route::is('admin.certificates.edit') ? route('admin.certificates.update', $certificateType) : route('admin.certificates.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Название</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $certificateType->name) }}" >
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="code" class="col-form-label">Код</label>
                                <input id="code" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $certificateType->code) }}" >
                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="certificate_type_parent_id" class="col-form-label">Родительский сертификат</label>
                                <select id="certificate_type_parent_id" class=" @error('certificate_type_parent_id') is-invalid @enderror" name="certificate_type_parent_id" >
                                    <option value="">-</option>
                                    @foreach($certificates as $certificate)
                                        <option @if($certificateType->certificate_type_parent_id == $certificate->id) selected @endif value="{{ $certificate->id }}">{{ $certificate->name }}</option>
                                    @endforeach
                                </select>
                                @error('certificate_type_parent_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="region" class="col-form-label">Регион</label>
                                <input id="region" class="form-control @error('region') is-invalid @enderror" name="region" value="{{ old('region', $certificateType->region) }}" >
                                @error('region')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="tides" class="col-form-label">Приливы</label>
                                <input id="tides" class="form-control @error('tides') is-invalid @enderror" name="tides" value="{{ old('tides', $certificateType->tides) }}" >
                                @error('tides')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="weather" class="col-form-label">Погода</label>
                                <input id="weather" class="form-control @error('weather') is-invalid @enderror" name="weather" value="{{ old('weather', $certificateType->weather) }}" >
                                @error('weather')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="priority" class="col-form-label">Приоритет</label>
                                <input id="priority" class="form-control @error('priority') is-invalid @enderror" name="priority" value="{{ old('priority', $certificateType->priority) }}" >
                                @error('priority')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="group" class="col-form-label">Группа</label>
                                <input id="group" class="form-control @error('group') is-invalid @enderror" name="group" value="{{ old('group', $certificateType->group) }}" >
                                @error('group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description" class="col-form-label">Описание</label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" >{{ old('group', $certificateType->description) }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
