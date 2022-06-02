@extends('layouts.app')

@section('content')
    <div class="container">
        Total: {{ $total }}
        <form action="{{ route('student.list') }}" method="GET">
            <div class="form-group row">
                <div class="col-md-4">
                    <select multiple name="schools[]" id="schools">
                        @foreach($russian_schools as $school)
                            <option @if(request()->get('schools') && in_array($school, request()->get('schools'))) selected @endif value="{{ $school }}">{{ $school }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label for="date_from">Окончание сертификата от</label>
                    <input type="date" id="date_from" name="date_from" class="form-control" value="{{ request('date_from') ? : '2022-01-01' }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to">Окончание сертификата до</label>
                    <input type="date" id="date_to" name="date_to" class="form-control" value="{{ request('date_to') ? : '2022-08-31' }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" id="search" name="search" class="btn btn-primary">Найти</button>
                </div>
            </div>
        </form>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Old ID</th>
                <th scope="col">ФИО</th>
                <th scope="col">Дата рождения</th>
                <th scope="col">Школы</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <th scope="row">{{ $student->id }}</th>
                    <th scope="row">{{ $student->old_id }}</th>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->birthday }}</td>
                    <td>{{ $student->school_names }}</td>
                    <td><a href="{{ route('student.student', $student->hash) }}">Перейти</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $students->appends(request()->all())->links() }}
    </div>
@endsection
