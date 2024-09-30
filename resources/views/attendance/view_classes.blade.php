@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <!-- Sidebar content here -->
            </div>

            <!-- Main content -->
            <div class="col-md-9 mt-5">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('teacher.space') }}">My Space</a></li> <!-- Lien vers la page d'accueil -->
                        <li class="breadcrumb-item active" aria-current="page">My Classes</li> <!-- Page actuelle -->
                    </ol>
                </nav>

                <h2 class="mb-4">My Classes</h2>

                <div class="row">
                    @foreach($classes as $class)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <i class="fas fa-chalkboard card-icon"></i> <!-- Utilisez une icône appropriée -->
                                    <h5 class="card-title">{{ $class->class_name }}</h5> <!-- Nom de la classe -->
                                    <p class="card-text">Manage attendance for students in {{ $class->class_name }}.</p>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <a href="{{ route('attendance.index', ['id' => $class->id]) }}" class="btn btn-secondary">Manage Attendance</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px; /* Espacement en bas du breadcrumb */
        }

        .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .card {
            transition: all 0.3s ease;
            overflow: hidden;
            border-radius: 10px; /* Arrondir les coins des cartes */
        }

        .card:hover {
            transform: translateY(-10px) scale(1.05); /* Agrandir légèrement la carte lors du survol */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée */
        }

        .card-icon {
            font-size: 5rem; /* Augmenter la taille de l'icône */
            margin-bottom: 1rem;
            color: #007bff;
            transition: transform 0.3s ease; /* Animer uniquement la transformation */
        }

        .card:hover .card-icon {
            transform: scale(1.2); /* Agrandir l'icône lors du survol */
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 2rem; /* Ajout de l'espace autour du contenu */
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease; /* Animer la couleur et la transformation */
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: scale(1.05); /* Agrandir le bouton lors du survol */
        }
    </style>
@endpush
