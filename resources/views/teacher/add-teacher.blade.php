@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Ajouter un Enseignant</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teacher/list/page') }}">Enseignants</a></li>
                            <li class="breadcrumb-item active">Ajouter un Enseignant</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('teacher/save') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Détails de l'Enseignant</span></h5>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <label>Nom Complet <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" placeholder="Entrez le nom complet" value="{{ old('full_name') }}">
                                            @error('full_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <label>Genre <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('gender') is-invalid @enderror" name="gender">
                                                <option value="">Sélectionner le Genre</option>
                                                <option value="female" {{ old('gender') == 'female' ? "selected" :""}}>Female</option>
                                                <option value="male" {{ old('gender') == 'male' ? "selected" :""}}>Male</option>
                                            </select>
                                            @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <label>Date de Naissance <span class="login-danger">*</span></label>
                                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                            @error('date_of_birth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <label>Téléphone <span class="login-danger">*</span></label>
                                            <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" placeholder="Entrez le Numéro de Téléphone" value="{{ old('phone_number') }}">
                                            @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Nouveau champ Email ajouté ici -->
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <label>Email <span class="login-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Entrez l'Email" value="{{ old('email') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Fin du champ Email -->

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <label>Qualification <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" placeholder="Entrez la Qualification" value="{{ old('qualification') }}">
                                            @error('qualification')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Ligne contenant Expérience et Adresse -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group local-forms">
                                                    <label>Expérience <span class="login-danger">*</span></label>
                                                    <input type="text" class="form-control @error('experience') is-invalid @enderror" name="experience" placeholder="Entrez l'Expérience" value="{{ old('experience') }}">
                                                    @error('experience')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group local-forms">
                                                    <label>Adresse <span class="login-danger">*</span></label>
                                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Entrez l'Adresse" value="{{ old('address') }}">
                                                    @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Ajouter l'Enseignant</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
