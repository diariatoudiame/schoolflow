@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-2">
                <!-- Sidebar content here -->
            </div>
            <div class="col-md-10 mt-5" style="margin-left: 300px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('teacher.space') }}">My Space</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('attendance.classe') }}">My Classes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Attendance for {{ $class->class_name }}</li>
                    </ol>
                </nav>

                <h2 class="mb-4">Attendance for {{ $class->class_name }}</h2>

                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="schedule_id">Select Schedule:</label>
                        <select name="schedule_id" id="schedule_id" class="form-control" required>
                            @foreach($schedules as $schedule)
                                <option value="{{ $schedule->id }}">{{ $schedule->day_of_week }} - {{ $schedule->start_time }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="date">Date:</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->first_name }}</td>
                                <td>{{ $student->last_name }}</td>
                                <td>
                                    <input type="hidden" name="attendance[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}][status]" value="present" id="present{{ $student->id }}" {{ isset($attendanceData[$student->id]) && $attendanceData[$student->id] === 'present' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="present{{ $student->id }}">Present</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}][status]" value="absent" id="absent{{ $student->id }}" {{ isset($attendanceData[$student->id]) && $attendanceData[$student->id] === 'absent' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="absent{{ $student->id }}">Absent</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}][status]" value="late" id="late{{ $student->id }}" {{ isset($attendanceData[$student->id]) && $attendanceData[$student->id] === 'late' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="late{{ $student->id }}">Late</label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-success mt-3">Save Attendance</button>
                </form>
                <a href="{{ route('attendance.download', $class->id) }}" class="btn btn-primary mt-3">Download the Attendance PDF</a>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }
        .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
        }
        .breadcrumb-item a:hover {
            text-decoration: underline;
        }
        .table {
            margin-top: 20px;
        }
        .form-check-label {
            margin-right: 10px;
        }
    </style>
@endpush
