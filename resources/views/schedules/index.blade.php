@extends('layouts.master')

@section('content')
    <div class="container">
        <h1 class="text-center">Emploi du Temps</h1>

        <!-- Bouton pour retourner à la page des emplois du temps -->
        <div class="text-left mb-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <!-- Bouton pour ajouter un emploi du temps (visible seulement pour l'administrateur) -->
        @if(auth()->user()->role_name !== 'Student' && auth()->user()->role_name !== 'Teacher')
            <div class="text-right mb-3" style="margin-left: 200px;">
                <a href="{{ route('schedules.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Ajouter un Emploi du Temps
                </a>
            </div>
        @endif

        <!-- Tableau de l'emploi du temps sous forme de calendrier -->
        <div class="table-responsive" style="margin-left: 200px;">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-dark">
                <tr>
                    <th>Heures</th>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>Samedi</th>
                    <th>Dimanche</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $startTime = strtotime('08:00');
                    $endTime = strtotime('18:00');
                    $timeInterval = 60 * 60; // intervalle d'une heure
                @endphp

                @for ($time = $startTime; $time <= $endTime; $time += $timeInterval)
                    <tr>
                        <!-- Affichage de l'heure (08:00, 09:00, etc.) -->
                        <td><strong>{{ date('H:i', $time) }}</strong></td>

                        <!-- Boucle pour afficher les cours pour chaque jour de la semaine -->
                        @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day)
                            <td>
                                @php
                                    $hasSchedule = false;
                                @endphp

                                @foreach ($schedules as $schedule)
                                    @if ($schedule->day_of_week === $day && strtotime($schedule->start_time) <= $time && strtotime($schedule->end_time) > $time)
                                        <div class="schedule-item">
                                            <strong>{{ $schedule->subject->subject_name }}</strong><br>
                                            <small>{{ $schedule->teacher->full_name }}</small><br>
                                            <small><em>{{ $schedule->class->class_name }}</em></small> <!-- Affichage du nom de la classe -->
                                            <hr class="my-1">
                                            <small>{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</small>
                                            <hr class="my-1">

                                            <!-- Icônes Modifier et Supprimer visibles seulement pour l'administrateur -->
                                            @if(auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teacher')
                                                <!-- Icône Modifier -->
                                                <a href="{{ route('schedules.edit', $schedule->id) }}" class="text-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            <!-- Icône Supprimer -->
                                            @if(auth()->user()->role_name === 'Admin')
                                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet emploi du temps ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 text-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        @php
                                            $hasSchedule = true;
                                        @endphp
                                    @endif
                                @endforeach

                                @if (!$hasSchedule)
                                    <!-- Si aucun cours n'est programmé pour cette heure -->
                                    <span class="text-muted">Libre</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
