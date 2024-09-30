@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Your Grades</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="DataList" class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="note-thread">
                                    <tr>
                                        <th>Subject</th>
                                        <th>Evaluation Type</th>
                                        <th>Grade</th>
                                        <th>Comment</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($grades as $grade)
                                        <tr>
                                            <td>{{ $grade->subject->subject_name }}</td>
                                            <td>{{ $grade->evaluation_type }}</td>
                                            <td>{{ $grade->grade }}</td>
                                            <td>{{ $grade->comment }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
