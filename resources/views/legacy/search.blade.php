@extends('layouts.legacy')
@section('content')
    <form action="{{ route('legacy_search') }}">
        <input type="text" name="scools" placeholder="Школы (можно через запятые)">
        <button type="submit">Искать</button>
    </form>
    <table border="1">
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        @foreach($scools as $scool)
            <tr>
                <td>{{ $scool->first_name }}</td>
                <td>{{ $scool->last_name }}</td>
                <td>{{ $scool->birthday }}</td>
                <td>{{ $scool->user_id }}</td>
                <td>{{ $scool->user_status }}</td>
                <td>{{ $scool->certificate_number }}</td>
                <td>{{ $scool->course_code }}</td>
                <td>{{ $scool->course_name }}</td>
                <td>{{ $scool->school_name }}</td>
                <td>{{ $scool->instructor_name }}</td>
                <td>{{ $scool->issue_date }}</td>
                <td>{{ $scool->expiry_date }}</td>
                <td>{{ $scool->revalidation_date }}</td>
            </tr>
        @endforeach
    </table>

@endsection
