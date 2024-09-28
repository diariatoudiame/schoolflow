@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'Emploi du Temps</h1>
    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">

        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="day_of_week">Jour de la Semaine</label>
            <select name="day_of_week" class="form-control" required>
                <option value="Lundi" {{ $schedule->day_of_week == 'Lundi' ? 'selected' : '' }}>Lundi</option>
                <option value="Mardi" {{ $schedule->day_of_week == 'Mardi' ? 'selected' : '' }}>Mardi</option>
                <option value="Mercredi" {{ $schedule->day_of_week == 'Mercredi' ? 'selected' : '' }}>Mercredi</option>
                <option value="Jeudi" {{ $schedule->day_of_week == 'Jeudi' ? 'selected' : '' }}>Jeudi</option>
                <option value="Vendredi" {{ $schedule->day_of_week == 'Vendredi' ? 'selected' : '' }}>Vendredi</option>
                <option value="Samedi" {{ $schedule->day_of_week == 'Samedi' ? 'selected' : '' }}>Samedi</option>
                <option value="Dimanche" {{ $schedule->day_of_week == 'Dimanche' ? 'selected' : '' }}>Dimanche</option>
            </select>
        </div>

        <div class="form-group">
            <label for="start_time">Heure de Début</label>
            <input type="time" name="start_time" class="form-control" value="{{ $schedule->start_time }}" required>
        </div>

        <div class="form-group">
            <label for="end_time">Heure de Fin</label>
            <input type="time" name="end_time" class="form-control" value="{{ $schedule->end_time }}" required>
        </div>

        <div class="form-group">
            <label for="subject_id">Matière</label>
            <select name="subject_id" class="form-control" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $subject->id == $schedule->subject_id ? 'selected' : '' }}>{{ $subject->subject_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="teacher_id">Professeur</label>
            <select name="teacher_id" class="form-control" required>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $teacher->id == $schedule->teacher_id ? 'selected' : '' }}>{{ $teacher->full_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection



