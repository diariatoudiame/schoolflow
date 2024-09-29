@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <!-- Sidebar (assuming it's in the master layout) -->
            <div class="col-md-3">
                <!-- Sidebar content here -->
            </div>

            <!-- Main content -->
            <div class="col-md-9 mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="{{ route('teacher.space') }}" class="btn btn-outline-secondary">Back</a>
                        </div>
                        <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                            <div class="card-header bg-gradient-primary text-white py-4">
                                <h2 class="mb-0 text-center">Teacher Profile</h2>
                            </div>
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-md-4 bg-light p-4 text-center">
{{--                                        <img src="{{ $teacher->avatar ?? asset('images/default-avatar.png') }}" alt="Profile Picture" class="rounded-circle mb-3 shadow" style="width: 180px; height: 180px; object-fit: cover;">--}}
                                        <h2 class="mb-1">{{ $teacher->full_name }}</h2>
                                        <p class="text-muted">{{ $teacher->qualification }}</p>
                                    </div>
                                    <div class="col-md-8 p-4">
                                        <ul class="nav nav-pills mb-4" id="profileTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="edit-tab" data-bs-toggle="pill" data-bs-target="#edit" type="button" role="tab" aria-controls="edit" aria-selected="false">Edit Profile</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="profileTabsContent">
                                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                                <div class="row g-3">
                                                    <div class="col-sm-6">
                                                        <div class="info-item">
                                                            <i class="fas fa-envelope text-primary"></i>
                                                            <div>
                                                                <small class="text-muted">Email</small>
                                                                <p>{{ $teacher->user->email }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="info-item">
                                                            <i class="fas fa-venus-mars text-primary"></i>
                                                            <div>
                                                                <small class="text-muted">Gender</small>
                                                                <p>{{ ucfirst($teacher->gender) }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="info-item">
                                                            <i class="fas fa-calendar-alt text-primary"></i>
                                                            <div>
                                                                <small class="text-muted">Date of Birth</small>
                                                                <p>{{ $teacher->date_of_birth }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="info-item">
                                                            <i class="fas fa-phone text-primary"></i>
                                                            <div>
                                                                <small class="text-muted">Phone</small>
                                                                <p>{{ $teacher->phone_number }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="info-item">
                                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                                            <div>
                                                                <small class="text-muted">Address</small>
                                                                <p>{{ $teacher->address }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="info-item">
                                                            <i class="fas fa-graduation-cap text-primary"></i>
                                                            <div>
                                                                <small class="text-muted">Qualification</small>
                                                                <p>{{ $teacher->qualification }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="info-item">
                                                            <i class="fas fa-briefcase text-primary"></i>
                                                            <div>
                                                                <small class="text-muted">Experience</small>
                                                                <p>{{ $teacher->experience }} years</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                                                <form action="{{ route('teacher.profile.update') }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label for="full_name" class="form-label">Full Name</label>
                                                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $teacher->full_name }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="{{ $teacher->user->email }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="gender" class="form-label">Gender</label>
                                                            <select class="form-select" id="gender" name="gender" required>
                                                                <option value="male" {{ $teacher->gender == 'male' ? 'selected' : '' }}>Male</option>
                                                                <option value="female" {{ $teacher->gender == 'female' ? 'selected' : '' }}>Female</option>
                                                                <option value="other" {{ $teacher->gender == 'other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                                                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $teacher->date_of_birth }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="qualification" class="form-label">Qualification</label>
                                                            <input type="text" class="form-control" id="qualification" name="qualification" value="{{ $teacher->qualification }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="experience" class="form-label">Experience (years)</label>
                                                            <input type="number" class="form-control" id="experience" name="experience" value="{{ $teacher->experience }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="phone_number" class="form-label">Phone Number</label>
                                                            <input type="tel" class="form-control" id="phone_number" name="phone_number" value="{{ $teacher->phone_number }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="address" class="form-label">Address</label>
                                                            <textarea class="form-control" id="address" name="address" rows="3" required>{{ $teacher->address }}</textarea>
                                                        </div>
                                                        <div class="col-12 mt-4">
                                                            <button type="submit" class="btn btn-primary me-2">Update Profile</button>
                                                            <a href="{{ route('teacher.space') }}" class="btn btn-outline-secondary">Cancel</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }
        .card {
            border: none;
            border-radius: 15px;
        }
        .card-header {
            border-radius: 15px 15px 0 0;
        }
        .nav-pills .nav-link {
            color: #4e73df;
            font-weight: 500;
            border-radius: 30px;
            padding: 8px 20px;
        }
        .nav-pills .nav-link.active {
            background-color: #4e73df;
            color: #fff;
        }
        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        .info-item i {
            font-size: 1.2rem;
            margin-right: 1rem;
            margin-top: 0.2rem;
        }
        .info-item p {
            margin-bottom: 0;
        }
        .form-control, .form-select {
            border-radius: 8px;
        }
        .btn {
            border-radius: 8px;
            padding: 8px 20px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
@endpush