@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Edit Student</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('student/list') }}">Students</a></li>
                                <li class="breadcrumb-item active">Edit Student</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- message --}}
            {!! Toastr::message() !!}

            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <form action="{{ route('student/update', $student->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Student Information
                                            <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span>
                                        </h5>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>First Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $student->first_name) }}">
                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Last Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $student->last_name) }}">
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Gender <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('gender') is-invalid @enderror" name="gender">
                                                <option value="Female" {{ old('gender', $student->gender) == 'Female' ? "selected" : "" }}>Female</option>
                                                <option value="Male" {{ old('gender', $student->gender) == 'Male' ? "selected" : "" }}>Male</option>
                                            </select>
                                            @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                            <label>Date Of Birth <span class="login-danger">*</span></label>
                                            <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" name="date_of_birth" type="text" value="{{ old('date_of_birth', $student->date_of_birth) }}">
                                            @error('date_of_birth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Roll </label>
                                            <input class="form-control @error('roll') is-invalid @enderror" type="text" name="roll" value="{{ old('roll', $student->roll) }}">
                                            @error('roll')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Blood Group <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('blood_group') is-invalid @enderror" name="blood_group">
                                                <option value="A+" {{ old('blood_group', $student->blood_group) == 'A+' ? "selected" : "" }}>A+</option>
                                                <option value="B+" {{ old('blood_group', $student->blood_group) == 'B+' ? "selected" : "" }}>B+</option>
                                                <option value="O+" {{ old('blood_group', $student->blood_group) == 'O+' ? "selected" : "" }}>O+</option>
                                            </select>
                                            @error('blood_group')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
{{--                                    <div class="col-12 col-sm-4">--}}
{{--                                        <div class="form-group local-forms">--}}
{{--                                            <label>E-Mail <span class="login-danger">*</span></label>--}}
{{--                                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email', $student->user->email) }}">--}}
{{--                                            @error('email')--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                                <strong>{{ $message }}</strong>--}}
{{--                                            </span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Phone Number <span class="login-danger">*</span></label>
                                            <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" value="{{ old('phone_number', $student->phone_number) }}">
                                            @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Academic Year <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('academic_year') is-invalid @enderror" name="academic_year">
                                                @php
                                                    $startYear = 2022;
                                                    $academicYears = [];
                                                    for ($i = 0; $i < 3; $i++) {
                                                        $academicYears[] = ($startYear + $i) . '-' . ($startYear + $i + 1);
                                                    }
                                                @endphp
                                                @foreach($academicYears as $year)
                                                    <option value="{{ $year }}" {{ old('academic_year', $student->academic_year) == $year ? "selected" : "" }}>{{ $year }}</option>
                                                @endforeach
                                            </select>
                                            @error('academic_year')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Class <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('class_id') is-invalid @enderror" name="class_id">
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? "selected" : "" }}>
                                                        {{ $class->class_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('class_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Current Image</label>
                                            <img src="{{ asset('storage/' . $student->upload) }}" alt="Current Image" style="max-width: 100px;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Upload New Image</label>
                                            <input class="form-control @error('upload') is-invalid @enderror" type="file" name="upload">
                                            @error('upload')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block">Update Student</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection