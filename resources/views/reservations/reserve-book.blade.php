@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Book Reservation</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('book/list/page') }}">Books</a></li>
                            <li class="breadcrumb-item active">Book Reservation</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('reservations.store', $book->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="book_title">Book Title</label>
                                            <input type="text" class="form-control" id="book_title" name="book_title" value="{{ $book->title }}" readonly>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="book_id" name="book_id" value="{{ $book->id }}" hidden>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="book_author">Book Author</label>
                                            <input type="text" class="form-control" id="book_author" name="book_author" value="{{ $book->author }}" readonly>
                                        </div>
                                    </div>
                                </div>




                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Reserve Book</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection