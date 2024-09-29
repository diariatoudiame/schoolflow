
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un Emploi du Temps pour la Classe : {{ $class->name }}</h1>
    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf
        
        <input type="hidden" name="class_id" value="{{ $class->id }}">
        
        <div class="form-group">
            <label for="day_of_week">Jour de la Semaine</label>
            <select name="day_of_week" class="form-control" required>
                <option value="">-- Sélectionner un jour --</option>
                <option value="Lundi">Lundi</option>
                <option value="Mardi">Mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
                <option value="Dimanche">Dimanche</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="start_time">Heure de Début</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_time">Heure de Fin</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="subject_id">Matière</label>
            <select name="subject_id" class="form-control" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="teacher_id">Professeur</label>
            <select name="teacher_id" class="form-control" required>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
@endsection
