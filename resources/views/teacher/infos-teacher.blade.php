@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-5"> <!-- Adjust here -->
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <!-- Sidebar content here -->
            </div>

            <!-- Main content -->
            <div class="col-md-9 mt-5">
                <h2>Teacher Details</h2>
                <div class="card">
                    <div class="card-header">
                        {{ $teacher->full_name }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $teacher->user->email }}</p>
                                <p><strong>Gender:</strong> {{ $teacher->gender }}</p>
                                <p><strong>Date of Birth:</strong> {{ $teacher->date_of_birth }}</p>
                                <p><strong>Qualification:</strong> {{ $teacher->qualification }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Experience:</strong> {{ $teacher->experience }} years</p>
                                <p><strong>Phone:</strong> {{ $teacher->phone_number }}</p>
                                <p><strong>Address:</strong> {{ $teacher->address }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('teacher/list/page') }}" class="btn btn-secondary">Back to the Teachers List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
