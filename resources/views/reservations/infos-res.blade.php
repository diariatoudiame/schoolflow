@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Reservation Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('book/list/page') }}">Books</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservations</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card reservation-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-0 text-truncate" title="{{ $reservation->book->title }}">{{ $reservation->book->title }}</h5>
                            <p class="card-text mt-3">
                                <strong>Author:</strong> <span class="text-truncate" title="{{ $reservation->book->author }}">{{ $reservation->book->author }}</span><br>
                                <strong>Reservation Date:</strong> {{ $reservation->reservation_date }}<br>
                                <strong>Duration:</strong> {{ $reservation->duration }} days
                            </p>

                            @php
                                $reservationEndDate = \Carbon\Carbon::parse($reservation->reservation_date)->addDays($reservation->duration);
                                $currentDate = \Carbon\Carbon::now();
                                $daysRemaining = $reservationEndDate->diffInDays($currentDate);
                            @endphp

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    @if ($daysRemaining > 0)
                                        <i class="fas fa-calendar-alt me-2"></i>{{ $daysRemaining }} days remaining
                                    @else
                                        <i class="fas fa-calendar-times me-2"></i>Reservation expired
                                    @endif
                                </span>
                                <a href="{{ route('reservations.index') }}" class="btn btn-primary">Back To Reservations</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
