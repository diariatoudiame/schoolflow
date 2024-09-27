@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row justify-content-center">
                    <div class="col text-center">
                        <h3 class="page-title">Détails de l'Événement</h3>
                    </div>
                    <div class="col-auto text-end float-end ms-auto d-flex justify-content-center">
                        @if(auth()->user()->role_name !== 'Student')
                            <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                        @endif
                        <a href="{{ route('schedules.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card event-card">
                        <div class="card-body text-center">
                            <h2 class="card-title display-4 mb-4">{{ $schedule->title }}</h2>
                            <p class="text-muted mb-4">{{ $schedule->description }}</p>

                            <div class="schedule-details">
                                <h4 class="mb-3">Jours de la Semaine</h4>
                                <p class="week-days">{{ implode(', ', explode(',', $schedule->week_days)) }}</p>
                            </div>

                            <a href="{{ route('schedules.index') }}" class="btn btn-secondary mt-4">Retour à la Liste</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Background and overall page adjustments */
        .event-card {
            background: linear-gradient(135deg, #ffedec 0%, #f9f3f2 100%);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            padding: 40px;
            border-radius: 20px;
        }

        /* Typography adjustments */
        .card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: #2a2a72;
        }

        .text-muted {
            font-family: 'Roboto', sans-serif;
            font-size: 1.2rem;
            color: #555;
        }

        .week-days {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            color: #d63031;
            font-weight: 600;
        }

        /* Button styling */
        .btn {
            padding: 8px 10px; /* Reduced padding for smaller buttons */
            font-family: 'Poppins', sans-serif;
            font-size: 1rem; /* Reduced font size */
            border-radius: 20px; /* Slightly smaller border radius */
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-secondary {
            background-color: #2ecc71;
            color: white;
        }

        /* Page title and breadcrumb styling */
        .page-header {
            margin-bottom: 50px;
        }

        .page-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            color: #2a2a72;
            font-weight: 200;
        }

        .breadcrumb {
            background: none;
            font-family: 'Roboto', sans-serif;
        }

        /* Additional UI improvements */
        .card {
            border: none;
        }

        .breadcrumb a {
            color: #3498db;
        }

        .breadcrumb-item.active {
            color: #2a2a72;
        }
    </style>
@endsection
