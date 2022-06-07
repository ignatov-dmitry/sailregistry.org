@extends('layouts.admin')

@section('title', 'Редактировать ' . $certificateType->name)

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ 'Редактировать ' . $certificateType->name}}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.certificates.update', $certificateType) }}" enctype="multipart/form-data">
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


                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
