@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Welcome, {{ Session::get('name') }}!</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Students</h6>
                                    <h3>{{ $nbr_students }}</h3>
                                    <p class="mb-0">Total registered students</p>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/dash-icon-01.svg') }}" alt="Students Icon">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
{{--                            <a href="#" class="text-secondary">View all students</a>--}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Classes</h6>
                                    <h3>{{ $nbr_classes }}</h3>
                                    <p class="mb-0">Total number of classes</p>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/dash-icon-02.svg') }}" alt="Classes Icon">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
{{--                            <a href="#" class="text-secondary">Manage classes</a>--}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Teachers</h6>
                                    <h3>{{ $nbr_teachers }}</h3>
                                    <p class="mb-0">Active teaching staff</p>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/dash-icon-03.svg') }}" alt="Teachers Icon">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
{{--                            <a href="#" class="text-secondary">View teachers</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 0.75rem 1.5rem;
        }
        .db-icon img {
            width: 50px;
            height: 50px;
        }
        .activity-feed {
            list-style: none;
            padding: 0;
        }
        .feed-item {
            padding-bottom: 1rem;
            padding-left: 30px;
            border-left: 2px solid #e9ecef;
            position: relative;
        }
        .feed-item:before {
            content: '';
            width: 10px;
            height: 10px;
            background-color: #007bff;
            border-radius: 50%;
            position: absolute;
            left: -6px;
            top: 0;
        }
        .feed-date {
            color: #6c757d;
            font-size: 0.85rem;
        }
        .todo-list {
            list-style: none;
            padding: 0;
        }
        .todo-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
        }
        .todo-item input[type="checkbox"] {
            margin-right: 1rem;
        }
    </style>
@endsection
