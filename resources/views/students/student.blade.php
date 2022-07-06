@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="profile row">
            <div class="col-md-6">
                <div class="id">ID: {{ $user->id }}</div>
                <div class="old_id">Old ID: {{ $user->old_id }}</div>
                <div class="last_name">Фамилия: {{ $user->last_name }}</div>
                <div class="first_name">Имя: {{ $user->first_name }}</div>
                <div class="middle_name">Отчество: {{ $user->middle_name }}</div>
                <div class="country">Страна: {{ $user->country }}</div>
                <div class="birthday">Дата рождения: {{ $user->birthday }}</div>
            </div>
            <div class="col-md-6">
                <img src="{{ $user->img_src }}" alt="{{ $user->full_name }}" class="img-thumbnail">
            </div>
        </div>
        <table class="table table-hover certificates">
            <thead>
            <tr>
                <th>Номер сертификата</th>
                <th>Код сертификата</th>
                <th>Сертификат</th>
                <th>Школа</th>
                <th>Инструктор</th>
                <th>Дата получения</th>
                <th>Дата окончания</th>
                <th>Первоначальная дата получения</th>
                <th>Статус</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($userCertificatesGroups as $key => $userCertificatesGroup)
                    @foreach($userCertificatesGroup as $certificate)
                        @php
                            $is_valid = $certificate->issue_date < $certificate->expiry_date;
                            $hasChild = $certificate->has_children_certificate;
                            $hasParent = !is_null($certificate->certificateType->certificate_type_parent_id);
                        @endphp
                        <tr class="@if($is_valid) table-success @else table-danger @endif">
                            <td>{{ $certificate->certificate_number }}</td>
                            <td>{{ $certificate->certificateType->code }}</td>
                            <td>{{ $certificate->certificateType->name }}</td>
                            <td>{{ $certificate->school->name }}</td>
                            <td>{{ $certificate->instructor->full_name }}</td>
                            <td>{{ $certificate->issue_date }}</td>
                            <td>{{ $certificate->expiry_date }}</td>
                            <td>{{ $certificate->original_issue ? : '-' }}</td>
                            <td>@if($is_valid) valid @else expired @endif</td>
                            <td>
                                @if(in_array($certificate->certificateType->code, ['S','CS','YS','TS','YCS','YCO','SRC']))
                                    <a class="btn btn-outline-success" href="{{ route('student.certificate_rus_data', [$user, $certificate->id]) }}">Генерировать сертификат</a>
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                    @role('super-admin', 'school-admin')
                    @if($hasParent && !$hasChild && !in_array($certificate->certificateType->code, ['S','CS','YS','TS','YCS','YCO','SRC']))
                    <tr>
{{--                        <td colspan="7"><td><a class="btn btn-outline-success" href="{{ route('student.certificate_data', ['user' => $user, 'group' => $key !== '' ? $key : 0]) }}">Генерировать сертификат</a></td></td>--}}
                        <td colspan="9"><td><a class="btn btn-outline-success" href="{{ route('student.create_certificate', ['user' => $user, 'group' => $key !== '' ? $key : 0]) }}">Выпустить сертификат</a></td></td>
                    </tr>
                    @endif
                    @endrole
                    <tr><td>1</td></tr>
                @endforeach
            </tbody>

        </table>
        <div class="card">
            <div class="card-header">
                PROFILE LINK QR CODE
            </div>
            <div class="card-body">
                <p class="text-center">{!! QrCode::size(120)->generate(route('student.student', $user->hash)); !!}</p>
            </div>
        </div>
    </div>
@endsection
