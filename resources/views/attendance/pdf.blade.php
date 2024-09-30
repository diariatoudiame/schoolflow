<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report for {{ $class->class_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h1>Attendance Report for {{ $class->class_name }}</h1>

<h2>Present Students</h2>
<table>
    <thead>
    <tr>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($presentStudents as $attendance)
        <tr>
            <td>{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2>Absent Students</h2>
<table>
    <thead>
    <tr>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($absentStudents as $attendance)
        <tr>
            <td>{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2>Late Students</h2>
<table>
    <thead>
    <tr>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lateStudents as $attendance)
        <tr>
            <td>{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
