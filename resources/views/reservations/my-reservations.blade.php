@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">My Reservations</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('book/list/page') }}">Books</a></li>
                            <li class="breadcrumb-item active">Reservations</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                @if(auth()->user()->role_name === 'Student')
                    {{-- Content for Student --}}
                    @forelse ($reservations as $reservation)
                        <div class="col-lg-4 col-md-6">
                            <div class="card reservation-card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title mb-0 text-truncate" title="{{ $reservation->book->title }}">{{ $reservation->book->title }}</h5>
                                    <p class="card-text mt-3">
                                        <strong>Author:</strong> <span class="text-truncate" title="{{ $reservation->book->author }}">{{ $reservation->book->author }}</span><br>
                                        <strong>Reservation Date:</strong> {{ $reservation->reservation_date }}<br>
                                        <strong>Duration:</strong> {{ $reservation->duration }} days<br>
                                        <strong>Status:</strong>
                                        <span class="text-{{ $reservation->book->status === 'available' ? 'success' : 'danger' }}">
                                            {{ $reservation->book->status === 'available' ? 'Returned' : 'Not Returned' }}
                                        </span>
                                    </p>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                            <div class="alert alert-info text-center border border-primary" style="width: 60%; font-size: 1.5rem; padding: 20px;">
                                <strong>Attention:</strong> You have no reservations.
                            </div>
                        </div>
                    @endforelse

                @elseif(auth()->user()->role_name === 'Librarian')
                    {{-- Content for Librarian --}}
                    @forelse ($bookReservees as $reservation)
                        <div class="col-lg-4 col-md-6">
                            <div class="card reservation-card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title mb-0 text-truncate" title="{{ $reservation->book->title }}">{{ $reservation->book->title }}</h5>
                                    <p class="card-text mt-3">
                                        <strong>Student:</strong> <span class="text-truncate" title="{{ $reservation->user->name }}">{{ $reservation->user->name }}</span><br>
                                        <strong>Reservation Date:</strong> {{ $reservation->reservation_date }}<br>
                                        <strong>Duration:</strong> {{ $reservation->duration }} days
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-primary">View Details</a>
                                            {{-- Button to Change Book Status --}}
                                            <form action="{{ route('reservations.updateStatus', $reservation->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-warning">Change Status</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                            <div class="alert alert-info text-center border border-primary" style="width: 60%; font-size: 1.5rem; padding: 20px;">
                                <strong> There are no reservations. </strong>
                            </div>
                        </div>
                    @endforelse
                @else
                    <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                        <div class="alert alert-warning text-center border border-danger" style="width: 60%; font-size: 1.5rem; padding: 20px;">
                            <strong>Error:</strong> Unauthorized access.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
