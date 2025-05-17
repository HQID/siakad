<!DOCTYPE html>
<html>
<head>
    <title>My Enrollments</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>My Enrollments</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Lecturer</th>
                <th>Semester</th>
                <th>Status</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $index => $enrollment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $enrollment->course->code }}</td>
                    <td>{{ $enrollment->course->name }}</td>
                    <td>{{ $enrollment->course->credits }}</td>
                    <td>{{ $enrollment->course->lecturer ? $enrollment->course->lecturer->full_name : 'Not Assigned' }}</td>
                    <td>{{ $enrollment->semester }} ({{ $enrollment->academic_year }})</td>
                    <td>{{ ucfirst($enrollment->status) }}</td>
                    <td>{{ $enrollment->grade ? $enrollment->grade->grade_letter : 'Not Graded' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
