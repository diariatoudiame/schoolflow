@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 70px;">
    <h1 class="text-center">
        Emploi du Temps
    </h1>

   <!-- Afficher les classes uniquement si l'utilisateur n'est pas un étudiant -->
   @if(auth()->user()->role_name !== 'Student')
    <h3 class="text-center">Liste des Classes :</h3>
    <ul>
        @foreach($classes as $class)
            <li>{{ $class->class_name }}</li>
        @endforeach
    </ul>
@endif


    <!-- Formulaire pour sélectionner une classe -->
     
    @if(auth()->user()->role_name !== 'Student' &&  auth()->user()->role_name !== 'Teachers')
    <form action="{{ route('schedules.filterByClass') }}" method="GET" class="mb-4">
        <div class="form-group row" style="margin-left: 200px;">
            <label for="class_id" class="col-sm-2 col-form-label">Sélectionner une Classe :</label>
            <div class="col-sm-6">
                <select name="class_id" id="class_id" class="form-control">
                    <option value="">-- Sélectionner une classe --</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ isset($selectedClass) && $selectedClass->id == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>

            <!-- Bouton pour sélectionner une classe avant de créer un emploi du temps -->
            <a href="{{ route('schedules.selectClass') }}" class="btn btn-primary mb-3">Ajouter un Emploi du Temps</a>
        </div>
    </form>
    @endif

    <!-- Tableau de l'emploi du temps -->
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
                        <td><strong>{{ date('H:i', $time) }}</strong></td>

                        @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day)
                            <td>
                                @php
                                    $hasSchedule = false;
                                @endphp
                                
                                @foreach ($schedules as $schedule)
                                    @if ($schedule->day_of_week === $day && strtotime($schedule->start_time) <= $time && strtotime($schedule->end_time) > $time)
                                        <div class="schedule-item">
                                            <strong>{{ $schedule->subject->subject_name }}</strong><br>
                                            <small>{{ $schedule->teacher->full_name }}</small>
                                            <hr class="my-1">
                                            <small>{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</small>
                                            <hr class="my-1">
                                        </div>
                                        @php
                                            $hasSchedule = true;
                                        @endphp
                                    @endif
                                @endforeach

                                @if (!$hasSchedule)
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
