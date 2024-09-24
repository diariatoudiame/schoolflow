@extends('layouts.master')

@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Book</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('book/list/page') }}">Books</a></li>
                            <li class="breadcrumb-item active">Edit Book</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('book/update', $book->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Basic Details</span></h5>
                                    </div>

                                    <!-- Hidden Field for Book Number -->
                                    <input type="hidden" name="book_number" value="{{ $book->book_number }}">

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Title <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Enter Title" value="{{ old('title', $book->title) }}">
                                            @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Author <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('author') is-invalid @enderror" name="author" placeholder="Enter Author Name" value="{{ old('author', $book->author) }}">
                                            @error('author')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                            <label>Publication Date <span class="login-danger">*</span></label>
                                            <input type="date" class="form-control @error('published_date') is-invalid @enderror" name="published_date" value="{{ old('published_date', $book->published_date) }}">
                                            @error('published_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Genre <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('genre') is-invalid @enderror" name="genre" placeholder="Enter Genre" value="{{ old('genre', $book->genre) }}">
                                            @error('genre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Quantity <span class="login-danger">*</span></label>
                                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" placeholder="Enter Quantity" value="{{ old('quantity', $book->quantity) }}" min="1">
                                            @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
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
