@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- ... En-tête inchangé ... -->
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card reservation-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-0 text-truncate" title="{{ $reservation->book->title }}">
                                {{ $reservation->book->title }}
                            </h5>
                            <p class="card-text mt-3">
                                <strong>Author:</strong>
                                <span class="text-truncate" title="{{ $reservation->book->author }}">
                                    {{ $reservation->book->author }}
                                </span><br>
                                <strong>Reservation Date:</strong> {{ $reservation->reservation_date }}<br>
                                <strong>Duration:</strong> {{ $reservation->duration }} days<br>
                                <strong>Return Date:</strong>
                                {{ \Carbon\Carbon::parse($reservation->reservation_date)->addDays($reservation->duration)->format('Y-m-d') }}
                            </p>
                            @php
                                $startDate = \Carbon\Carbon::parse($reservation->reservation_date);
                                $endDate = $startDate->copy()->addDays($reservation->duration);
                                $today = \Carbon\Carbon::now()->startOfDay();

                                // Si nous sommes avant la date de début
                                if ($today->lt($startDate)) {
                                    $daysRemaining = $reservation->duration;
                                    $status = 'pending';
                                }
                                // Si nous sommes entre la date de début et la date de fin
                                elseif ($today->lte($endDate)) {
                                    $daysRemaining = $today->diffInDays($endDate);
                                    $status = 'active';
                                }
                                // Si nous sommes après la date de fin
                                else {
                                    $daysRemaining = -$today->diffInDays($endDate);
                                    $status = 'expired';
                                }
                            @endphp
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    @if ($status === 'pending')
                                        <i class="fas fa-clock me-2"></i>Reservation starts in {{ $today->diffInDays($startDate) }} days
                                    @elseif ($status === 'active')
                                        @if ($daysRemaining > 1)
                                            <i class="fas fa-calendar-alt me-2"></i>{{ $daysRemaining }} days remaining
                                        @elseif ($daysRemaining == 1)
                                            <i class="fas fa-exclamation-triangle me-2"></i>Last day tomorrow
                                        @else
                                            <i class="fas fa-exclamation-triangle me-2"></i>Last day today
                                        @endif
                                    @else
                                        <i class="fas fa-calendar-times me-2"></i>Reservation expired {{ abs($daysRemaining) }} days ago
                                    @endif
                                </span>
                                <div>
                                    @if ($status === 'active' && $daysRemaining <= 2)
                                        <button class="btn btn-warning me-2">Extend Reservation</button>
                                    @endif
                                    <a href="{{ route('reservations.index') }}" class="btn btn-primary">
                                        Back to Reservations
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection