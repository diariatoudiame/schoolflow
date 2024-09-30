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
                <h2 class="mb-4">My Space</h2>
                <div class="row">
                    <!-- Card 1: Manage own class/section -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="fas fa-chalkboard-teacher card-icon"></i>
                                <h5 class="card-title">Class Management</h5>
                                <p class="card-text">Manage your own class or section, including student lists and class activities.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('attendance.classe') }}" class="btn btn-primary">Access</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Exam records management -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="fas fa-file-alt card-icon"></i>
                                <h5 class="card-title">Exam Records</h5>
                                <p class="card-text">Manage exam records for your subjects, including grades and assessments.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('teacher.classe') }}" class="btn btn-primary">Access</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Timetable management -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="fas fa-calendar-alt card-icon"></i>
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
                                <i class="fas fa-user-circle card-icon"></i>
                                <h5 class="card-title">My Profile</h5>
                                <p class="card-text">Manage your personal information, qualifications, and contact details.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('teacher.profile.edit') }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .card-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #007bff;
            transition: all 0.3s ease;
        }
        .card:hover .card-icon {
            transform: scale(1.1);
        }
        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
@endpush