@extends('layouts.app')

@section('content')
    <div class="container">
        {{--    <h1>Add Schedule for Class: {{ $class->name }}</h1> --}}
        <h1>Add a Schedule</h1>
        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf

            {{--        <input type="hidden" name="class_id" value="{{ $class->id }}"> --}}

            <div class="form-group">
                <label for="day_of_week">Day of the Week</label>
                <select name="day_of_week" class="form-control" required>
                    <option value="">-- Select a day --</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="subject_id">Subject</label>
                <select name="subject_id" class="form-control" required>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="teacher_id">Teacher</label>
                <select name="teacher_id" class="form-control" required>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="class_id">Class</label>
                <select name="class_id" class="form-control" required>
                    @foreach ($classes as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->class_name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
@endsection
