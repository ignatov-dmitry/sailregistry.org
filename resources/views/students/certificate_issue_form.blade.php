@extends('layouts.app')
@section('content')
    <div class="container">
        <form style="padding: 0 20%" action="{{ route('student.issue_certificate', [$certificate->user, $group]) }}" method="post">
            @csrf
            <input type="hidden" name="user_id">
            <div class="form-group">
                <label for="full_name">ФИО</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="{{ $certificate->user->full_name }}">
            </div>

            <div class="form-group">
                <label for="certificate_id">Название сертификата</label>
                <select name="certificate_id" id="certificate_id">
                    @php
                    $selectedId = $certificate->certificateType->parent ? $certificate->certificateType->parent->id : $certificate->certificateType->id
                    @endphp
                    @foreach($certificateTypes as $certificateType)
                        <option @if($selectedId == $certificateType->id) selected @endif value="{{ $certificateType->id }}">{{ $certificateType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="issue_date">Дата начала</label>
                <input type="text" id="issue_date" name="issue_date" class="form-control date" value="{{ date_format(date_create($certificate->issue_date), 'd.m.Y') }}">
            </div>
            <div class="form-group">
                <label for="expiry_date">Дата окончания</label>
                <input type="text" id="expiry_date" name="expiry_date" class="form-control date" value="{{ date_format(date_create($certificate->expiry_date), 'd.m.Y') }}">
            </div>
            <div class="form-group">
                <label for="original_issue">Первое получение</label>
                <a href="{{ route('redirectToIytnet', [$certificate->user->old_id]) }}" rel="noreferrer" target="_blank">Посмотреть на iytnet</a>
                <input type="text" id="original_issue" name="original_issue" class="form-control date" value="{{ $certificate->original_issue ? date_format(date_create($certificate->original_issue), 'd.m.Y') : '' }}">
            </div>


            <button name="send" value="I" class="btn btn-outline-success">Выпустить сертификат</button>
        </form>
    </div>
@endsection
