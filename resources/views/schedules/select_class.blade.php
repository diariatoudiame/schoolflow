@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Choisir une Classe</h1>
    <form action="{{ route('schedules.create.forClass') }}" method="GET">
        <div class="form-group">
            <label for="class_id">Sélectionnez une Classe</label>
            <select name="class_id" class="form-control" required>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Suivant</button>
    </form>
</div>
@endsection
