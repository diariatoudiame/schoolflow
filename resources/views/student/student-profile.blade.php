@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Student Details</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('student/add/page') }}">Student</a></li>
                                <li class="breadcrumb-item active">Student Details</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-info">
                                <h4>Profile <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h4>
                            </div>
                            <div class="student-profile-head">
                                <div class="profile-bg-img">
                                    <img src="{{ URL::to('assets/img/profile-bg.jpg') }}" alt="Profile">
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="profile-user-box">
                                            <div class="profile-user-img">
                                                <img src="{{ Storage::url('student-photos/'.$studentProfile->upload) }}" alt="Profile">
                                                <div class="form-group students-up-files profile-edit-icon mb-0">
                                                    <div class="uplod d-flex">
                                                        <label class="file-upload profile-upbtn mb-0">
                                                            <i class="far fa-edit me-2-3"></i>
                                                            <input type="file" accept="image/*" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="names-profiles">
                                                <h4>{{ $studentProfile->first_name }} {{ $studentProfile->last_name }}</h4>
                                                <h5>Computer Science</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center">
                                        <div class="follow-group">
                                            <div class="students-follows">
                                                <h5>Followers</h5>
                                                <h4>2850</h4>
                                            </div>
                                            <div class="students-follows">
                                                <h5>Following</h5>
                                                <h4>300</h4>
                                            </div>
                                            <div class="students-follows">
                                                <h5>Posts</h5>
                                                <h4>45</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center">
                                        <div class="follow-btn-group">
                                            <button type="submit" class="btn btn-info follow-btns">Follow</button>
                                            <button type="submit" class="btn btn-info message-btns">Message</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="student-personals-grp">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>Personal Details:</h4>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-user"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Name</h4>
                                                <h5>{{ $studentProfile->first_name }} {{ $studentProfile->last_name }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <img src="{{ URL::to('assets/img/icons/building-icon.svg') }}" alt="">
                                            </div>
                                            <div class="views-personal">
                                                <h4>Department</h4>
                                                <h5>Computer Science</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-phone-call"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Mobile</h4>
                                                <h5>{{ $studentProfile->phone_number }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-mail"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Email</h4>
                                                <h5><a href="mailto:{{ $studentProfile->email }}">{{ $studentProfile->email }}</a></h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-user"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Gender</h4>
                                                <h5>{{ $studentProfile->gender }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-calendar"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Date of Birth</h4>
                                                <h5>{{ $studentProfile->date_of_birth }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-italic"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Language</h4>
                                                <h5>English, French, Bangla</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity mb-0">
                                            <div class="personal-icons">
                                                <i class="feather-map-pin"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Address</h4>
                                                <h5>480, Eastern Avenue, New York</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="student-personals-grp">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>Skills:</h4>
                                        </div>
                                        <div class="skill-blk">
                                            <div class="skill-statistics">
                                                <div class="skills-head">
                                                    <h5>Photoshop</h5>
                                                    <p>90%</p>
                                                </div>
                                                <div class="progress mb-0">
                                                    <div class="progress-bar bg-photoshop" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="skill-statistics">
                                                <div class="skills-head">
                                                    <h5>Code Editor</h5>
                                                    <p>75%</p>
                                                </div>
                                                <div class="progress mb-0">
                                                    <div class="progress-bar bg-editor" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="skill-statistics mb-0">
                                                <div class="skills-head">
                                                    <h5>Illustrator</h5>
                                                    <p>95%</p>
                                                </div>
                                                <div class="progress mb-0">
                                                    <div class="progress-bar bg-illustrator" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="student-personals-grp">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>About Me</h4>
                                        </div>
                                        <div class="hello-park">
                                            <h5>Hello, I am {{ $studentProfile->first_name }} {{ $studentProfile->last_name }}</h5>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                                ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                aliquip ex commodo consequat. Duis aute irure dolor in reprehenderit
                                                in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                                Excepteur officia deserunt mollit anim id est laborum.</p>
                                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                                                accusantium doloremque laudantium, totam inventore veritatis et
                                                quasi architecto beatae vitae dicta sunt explicabo.</p>
                                        </div>
                                        <div class="hello-park">
                                            <div class="students-documents">
                                                <h4>Documents</h4>
                                                <div class="documents-links">
                                                    <a href="javascript:;">CV</a>
                                                    <a href="javascript:;">Cover Letter</a>
                                                    <a href="javascript:;">Transcripts</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="student-personals-grp">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>My Posts</h4>
                                        </div>
                                        <div class="students-posts">
                                            <div class="posts-grid">
                                                <div class="post-block">
                                                    <img src="{{ URL::to('assets/img/post1.jpg') }}" alt="Post">
                                                    <div class="post-overlay">
                                                        <h5>Beautiful Day!</h5>
                                                        <p>11:20 am</p>
                                                    </div>
                                                </div>
                                                <div class="post-block">
                                                    <img src="{{ URL::to('assets/img/post2.jpg') }}" alt="Post">
                                                    <div class="post-overlay">
                                                        <h5>Study Time!</h5>
                                                        <p>11:25 am</p>
                                                    </div>
                                                </div>
                                                <div class="post-block">
                                                    <img src="{{ URL::to('assets/img/post3.jpg') }}" alt="Post">
                                                    <div class="post-overlay">
                                                        <h5>Outdoor Fun!</h5>
                                                        <p>11:30 am</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <a href="javascript:;" class="btn btn-primary mt-3">View All Posts</a>
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
