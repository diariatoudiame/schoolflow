@extends('layouts.master')

@section('content')

    <div class="container" style="margin-top: 70px;">
        <h1 class="text-center">
            Timetable
        </h1>

        <!-- Display classes only if the user is not a student -->
        @if(auth()->user()->role_name !== 'Student')
            <h3 class="text-center">List of Classes:</h3>
            <ul>
                @foreach($classes as $class)
                    <li>{{ $class->class_name }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Form to select a class -->

        @if(auth()->user()->role_name !== 'Student' && auth()->user()->role_name !== 'Teachers')
            <form action="{{ route('schedules.filterByClass') }}" method="GET" class="mb-4">
                <div class="form-group row" style="margin-left: 200px;">
                    <label for="class_id" class="col-sm-2 col-form-label">Select a Class:</label>
                    <div class="col-sm-6">
                        <select name="class_id" id="class_id" class="form-control">
                            <option value="">-- Select a class --</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ isset($selectedClass) && $selectedClass->id == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>

                    <!-- Button to select a class before creating a timetable -->
                    <a href="{{ route('schedules.selectClass') }}" class="btn btn-primary mb-3">Add Timetable</a>
                </div>
            </form>
        @endif

        <!-- Timetable Table -->
        <div class="table-responsive" style="margin-left: 200px;">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-dark">

                <div class="container">
                    <h1 class="text-center">Timetable</h1>

                    <!-- Button to return to the timetable page -->
                    <div class="text-left mb-3">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>

                    <!-- Button to add a timetable (visible only to the administrator) -->
                    @if(auth()->user()->role_name !== 'Student' && auth()->user()->role_name !== 'Teacher')
                        <div class="text-right mb-3" style="margin-left: 200px;">
                            <a href="{{ route('schedules.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Timetable
                            </a>
                        </div>
                    @endif

                    <!-- Timetable in calendar form -->
                    <div class="table-responsive" style="margin-left: 200px;">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="thead-dark">

                            <tr>
                                <th>Time</th>
                                <th>Monday</th>
                                <th>Tuesday</th>
                                <th>Wednesday</th>
                                <th>Thursday</th>
                                <th>Friday</th>
                                <th>Saturday</th>
                                <th>Sunday</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $startTime = strtotime('08:00');
                                $endTime = strtotime('18:00');
                                $timeInterval = 60 * 60; // interval of one hour
                            @endphp

                            @for ($time = $startTime; $time <= $endTime; $time += $timeInterval)
                                <tr>
                                    <td><strong>{{ date('H:i', $time) }}</strong></td>

                                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <td>
                                            @php
                                                $hasSchedule = false;
                                            @endphp

                                            @foreach ($schedules as $schedule)
                                                @if ($schedule->day_of_week === $day && strtotime($schedule->start_time) <= $time && strtotime($schedule->end_time) > $time)
                                                    <div class="schedule-item">
                                                        <strong>{{ $schedule->subject->subject_name }}</strong><br>
                                                        <small>{{ $schedule->teacher->full_name }}</small><br>
                                                        <small><em>{{ $schedule->class->class_name }}</em></small> <!-- Display class name -->
                                                        <hr class="my-1">
                                                        <small>{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</small>
                                                        <hr class="my-1">


                                                        <!-- Edit and Delete icons visible only to admin -->
                                                        @if(auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teacher')
                                                            <!-- Edit Icon -->
                                                            <a href="{{ route('schedules.edit', $schedule->id) }}" class="text-warning">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endif

                                                        <!-- Delete Icon -->
                                                        @if(auth()->user()->role_name === 'Admin')
                                                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this timetable?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-link p-0 text-danger">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                    </div>
                                                    @php
                                                        $hasSchedule = true;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @if (!$hasSchedule)
                                                <span class="text-muted">Free</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
@endsection
