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
                @forelse ($reservations as $reservation)
                    <div class="col-lg-4 col-md-6">
                        <div class="card reservation-card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-0 text-truncate" title="{{ $reservation->book->title }}">{{ $reservation->book->title }}</h5>
                                <p class="card-text mt-3">
                                    <strong>Author:</strong> <span class="text-truncate" title="{{ $reservation->book->author }}">{{ $reservation->book->author }}</span><br>
                                    <strong>Reservation Date:</strong> {{ $reservation->reservation_date }}<br>
                                    <strong>Duration:</strong> {{ $reservation->duration }} days
                                </p>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">You don't have any reservations at the moment.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
