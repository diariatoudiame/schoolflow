@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Grade List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.classe') }}">My Classes</a></li>
                            <li class="breadcrumb-item active">Grade List</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Grades for Class: {{ $class->class_name }}</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        @if(auth()->user()->role_name === 'Teacher')
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGradeModal">
                                                <i class="fas fa-plus"></i> Add Grade
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="DataList" class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="note-thread">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Subject</th>
                                        <th>Evaluation Type</th>
                                        <th>Grade</th>
                                        <th>Comment</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($grades as $grade)
                                        <tr>
                                            <td>{{ $grade->student->first_name }} {{ $grade->student->last_name }}</td>
                                            <td>{{ $grade->subject->subject_name }}</td>
                                            <td>{{ $grade->evaluation_type }}</td>
                                            <td>{{ $grade->grade }}</td>
                                            <td>{{ $grade->comment }}</td>
                                            <td class="text-end">
                                                @if(auth()->user()->role_name === 'Teacher')
                                                    <a href="#" class="btn btn-sm bg-danger-light grade_edit" data-bs-toggle="modal" data-bs-target="#editGradeModal"
                                                       data-id="{{ $grade->id }}"
                                                       data-student-id="{{ $grade->student->id }}"
                                                       data-subject-id="{{ $grade->subject->id }}"
                                                       data-evaluation-type="{{ $grade->evaluation_type }}"
                                                       data-grade="{{ $grade->grade }}"
                                                       data-comment="{{ $grade->comment }}">
                                                        <i class="far fa-edit me-2"></i> Edit
                                                    </a>
                                                    <a href="#" class="btn btn-sm bg-danger-light grade_delete" data-bs-toggle="modal" data-bs-target="#gradeDelete" data-id="{{ $grade->id }}">
                                                        <i class="far fa-trash-alt me-2"></i> Delete
                                                    </a>
                                                @endif
                                            </td>
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

    {{-- Add Grade Modal --}}
    <div class="modal custom-modal fade" id="addGradeModal" tabindex="-1" role="dialog" aria-labelledby="addGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGradeModalLabel">Add Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('grades.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="student_id">Select Student</label>
                            <select class="form-control" id="student_id" name="student_id" required>
                                <option value="">-- Select a student --</option>
                                @foreach ($class->students as $student)
                                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select class="form-control" id="subject_id" name="subject_id" required>
                                <option value="">-- Select a subject --</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="evaluation_type">Evaluation Type</label>
                            <select class="form-control" id="evaluation_type" name="evaluation_type" required>
                                <option value="">-- Select evaluation type --</option>
                                <option value="Exam">Exam</option>
                                <option value="Assignment">Assignment</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="score">Grade</label>
                            <input type="number" class="form-control" id="grade" name="grade" min="0" max="20" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Grade Modal --}}
    <div class="modal custom-modal fade" id="editGradeModal" tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('grades.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="grade_id" id="edit_grade_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_student_id">Student</label>
                            <select class="form-control" id="edit_student_id" name="student_id" required>
                                @foreach ($class->students as $student)
                                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_subject_id">Subject</label>
                            <select class="form-control" id="edit_subject_id" name="subject_id" required>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_evaluation_type">Evaluation Type</label>
                            <select class="form-control" id="edit_evaluation_type" name="evaluation_type" required>
                                <option value="Exam">Exam</option>
                                <option value="Assignment">Assignment</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_grade">Grade</label>
                            <input type="number" class="form-control" id="edit_grade" name="grade" min="0" max="20" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_comment">Comment</label>
                            <textarea class="form-control" id="edit_comment" name="comment" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Grade Modal --}}
    <div class="modal custom-modal fade" id="gradeDelete" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Grade</h3>
                        <p>Are you sure you want to delete this grade?</p>
                    </div>
                    <form action="{{ route('grades.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="grade_id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
