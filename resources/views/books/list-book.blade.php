@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Library</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Library</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="book-group-form">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by ID ...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by Title ..."> <!-- Change to Title -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by Author ..."> <!-- Change to Author -->
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-book-btn">
                            <button type="button" class="btn btn-primary">Search</button>
                        </div>
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
                                        <h3 class="page-title">Books</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="books.html" class="btn btn-outline-gray me-2 active">
                                            <i class="fa fa-list" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('book/grid/page') }}" class="btn btn-outline-gray me-2">
                                            <i class="fa fa-th" aria-hidden="true"></i>
                                        </a>
                                        @if(auth()->user()->role_name === 'Librarian')
                                            <a href="{{ route('book/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>

                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="DataList" class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="book-thread">
                                    <tr>
                                        <th>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Title</th> <!-- Change to Title -->
                                        <th>Author</th> <!-- Change to Author -->
                                        <th>Genre</th> <!-- Change to Genre -->
                                        <th>Publication Date</th> <!-- Change to Publication Date -->
                                        <th>Status</th> <!-- Change to Publication Date -->
                                        <th class="text-end">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($books as $book) <!-- Change to $books -->
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td hidden class="book_id">{{ $book->id }}</td> <!-- Change to book_id -->
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->title }}</td> <!-- Change to Title -->
                                        <td>{{ $book->author }}</td> <!-- Change to Author -->
                                        <td>{{ $book->genre }}</td> <!-- Change to Genre -->
                                        <td>{{ $book->published_date }}</td> <!-- Change to Publication Date -->
                                        <td>{{ $book->status }}</td>
                                        <td class="text-end">
                                            <div class="actions">
                                                @if(auth()->user()->role_name === 'Librarian')
                                                <a href="{{ url('book/edit/'.$book->id) }}" class="btn btn-sm bg-danger-light">
                                                    <i class="far fa-edit me-2"></i>
                                                </a>
                                                @endif
                                                    @if(auth()->user()->role_name === 'Librarian')
                                                <a href="{{ url('book/infos/'.$book->id) }}" class="btn btn-sm bg-danger-light">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                </a>
                                                    @endif
                                                    @if(auth()->user()->role_name === 'Student')
                                                        @if($book->status === 'available')
                                                        <a href="{{ url('reservations/create/'.$book->id) }}" class="btn btn-sm bg-danger-light">
                                                            <i class="fas fa-calendar-check"></i>
                                                        </a>
                                                        @endif
                                                    @endif
                                            </div>
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

    {{-- modal book delete --}}
    <div class="modal custom-modal fade" id="bookDelete" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Book</h3>
                        <p>Are you sure you want to delete this book?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('book/delete') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" class="e_book_id" value=""> <!-- Change to e_book_id -->
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn" style="border-radius: 5px !important;">Delete</button>
                                </div>
                                <div class="col-6">
                                    <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        {{-- delete js --}}
        <script>
            $(document).on('click','.book_delete',function()
            {
                var _this = $(this).parents('tr');
                $('.e_book_id').val(_this.find('.book_id').text());
            });
        </script>
    @endsection

@endsection
