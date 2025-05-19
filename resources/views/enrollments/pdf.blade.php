<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mata Kuliah</title>
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
    <h1>Daftar Mata Kuliah</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Dosen</th>
                <th>Semester</th>
                <th>Status</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $index => $enrollment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $enrollment->course->code }}</td>
                    <td>{{ $enrollment->course->name }}</td>
                    <td>{{ $enrollment->course->credits }}</td>
                    <td>{{ $enrollment->course->lecturer ? $enrollment->course->lecturer->full_name : 'Belum Ditentukan' }}</td>
                    <td>{{ $enrollment->semester }} ({{ $enrollment->academic_year }})</td>
                    <td>{{ ucfirst($enrollment->status) }}</td>
                    <td>{{ $enrollment->grade ? $enrollment->grade->grade_letter : 'Belum Dinilai' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
