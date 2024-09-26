@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Class</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="classes.html">Class</a></li>
                            <li class="breadcrumb-item active">Edit Class</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('class/update', $class->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Ajout de la méthode PUT pour l'update -->
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Class Information</span></h5>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Class Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="class_name" value="{{ $class->class_name }}" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Update</button>
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
