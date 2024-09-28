@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <!-- Sidebar content here -->
            </div>

            <!-- Main content -->
            <div class="col-md-9 mt-5">
                <h2 class="mb-4">Teacher Space</h2>
                <div class="row">
                    <!-- Card 1: Manage own class/section -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Class Management</h5>
                                <p class="card-text">Manage your own class or section, including student lists and class activities.</p>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn btn-primary">Access</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Exam records management -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Exam Records</h5>
                                <p class="card-text">Manage exam records for your subjects, including grades and assessments.</p>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn btn-primary">Access</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Timetable management -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Timetable</h5>
                                <p class="card-text">Manage the class timetable if you are designated as the homeroom teacher.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.calendar') }}" class="btn btn-primary">Access</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Manage own profile -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">My Profile</h5>
                                <p class="card-text">Manage your personal information, qualifications, and contact details.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('teacher.profile.edit') }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5: Download study material -->
{{--                    <div class="col-md-4 mb-4">--}}
{{--                        <div class="card h-100">--}}
{{--                            <div class="card-body">--}}
{{--                                <h5 class="card-title">Study Material</h5>--}}
{{--                                <p class="card-text">Download and share study material for your students.</p>--}}
{{--                            </div>--}}
{{--                            <div class="card-footer">--}}
{{--                                <a href="#" class="btn btn-primary">Download</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
