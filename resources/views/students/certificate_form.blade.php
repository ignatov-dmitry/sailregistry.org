@extends('layouts.app')
@section('content')
    <div class="container">
        <form style="padding: 0 20%" action="{{ route('student.get_certificate', $certificate->user) }}" method="post">
            @csrf
            <input type="hidden" name="user_id">
            <div class="form-group">
                <label for="full_name">ФИО</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="{{ $certificate->user->full_name }}">
            </div>

            <div class="form-group">
                <label for="certificate_name">Название сертификата</label>
                <input type="text" id="certificate_name" name="certificate_name" class="form-control" value="{{ $certificate->certificateType->parent ? $certificate->certificateType->parent->name : $certificate->certificateType->name }}">
            </div>
            <div class="form-group">
                <label for="certificate_code">Код сертификата</label>
                <input type="text" id="certificate_code" name="certificate_code" class="form-control" value="{{ $certificate->certificateType->parent ? $certificate->certificateType->parent->code : $certificate->certificateType->code }}">
            </div>
            <div class="form-group">
                <label for="certificate_number">Номер сертификата</label>
                <input type="text" id="certificate_number" name="certificate_number" class="form-control" value="{{ $certificate->certificate_number }}">
            </div>
            <div class="form-group">
                <label for="issue_date">Дата начала</label>
                <input type="text" id="issue_date" name="issue_date" class="form-control" value="{{ date_format(date_create($certificate->issue_date), 'd.m.Y') }}">
            </div>
            <div class="form-group">
                <label for="expiry_date">Дата окончания</label>
                <input type="text" id="expiry_date" name="expiry_date" class="form-control" value="{{ date_format(date_create($certificate->expiry_date), 'd.m.Y') }}">
            </div>
            <div class="form-group">
                <label for="revalidation_date">Первое получение</label>
                <input type="text" id="revalidation_date" name="revalidation_date" class="form-control" value="{{ $certificate->revalidation_date ? date_format(date_create($certificate->revalidation_date), 'd.m.Y') : '' }}">
            </div>
            <div class="form-group">
                <label for="birthday">Дата рождения</label>
                <input type="text" id="birthday" name="birthday" class="form-control" value="{{ date_format(date_create($certificate->user->birthday), 'd.m.Y') }}">
            </div>

            <div class="form-group">
                <label for="description">Описание сертификата</label>
                <textarea id="description" name="description" class="form-control">{{ $description }}</textarea>
            </div>
            <button name="send" value="I" class="btn btn-outline-success">Просмотр</button>
            <button name="send" value="D"  class="btn btn-outline-success">Скачать PDF</button>
            <button name="send" value="EPS"  class="btn btn-outline-success">Скачать EPS</button>
        </form>
    </div>
@endsection
