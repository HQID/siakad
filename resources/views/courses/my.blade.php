@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Courses</h1>
    @if($courses->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Credits</th>
                    <th>Semester</th>
                    <th>Lecturer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->code }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->credits }}</td>
                        <td>{{ $course->semester }}</td>
                        <td>{{ $course->lecturer->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $courses->links() }}
    @else
        <p>No courses found.</p>
    @endif
</div>
@endsection
