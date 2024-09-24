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
                <h2>Book Details</h2>
                <div class="card">
                    <div class="card-header">
                        {{ $book->title }} <!-- Adjusting to book title -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Book Number:</strong> {{ $book->book_number }}</p> <!-- Displaying book number -->
                                <p><strong>Author:</strong> {{ $book->author }}</p> <!-- Adjusting to author -->
                                 <!-- Formatting the date -->
                            </div>
                            <div class="col-md-6">
                                <p><strong>Genre:</strong> {{ $book->genre }}</p> <!-- Adjusting to genre -->
                                <p><strong>Publication Date:</strong> {{ \Carbon\Carbon::parse($book->published_date)->format('d-m-Y') }}</p> <!-- Adjusting to description -->
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('book/list/page') }}" class="btn btn-secondary">Back to the Books List</a> <!-- Adjusting the route -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
