<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <!-- Main Menu -->
                <li class="menu-title"><span>Main Menu</span></li>
                <li class="{{set_active(['setting/page'])}}">
                    <a href="{{ route('setting/page') }}"><i class="fas fa-cog"></i><span>Settings</span></a>
                </li>

                <!-- Dashboard (for all users) -->
                <li class="submenu {{set_active(['home','teacher/dashboard','student/dashboard'])}}">
                    <a href="#"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span><span class="menu-arrow"></span></a>
                    <ul>
                        @if(auth()->check())
                            @if(auth()->user()->role_name === 'Admin')
                                <li><a href="{{ route('home') }}" class="{{ set_active(['home']) }}">Admin Dashboard</a></li>
                            @elseif(auth()->user()->role_name === 'Teachers')
                                <li><a href="{{ route('teacher/dashboard') }}" class="{{ set_active(['teacher/dashboard']) }}">Teacher Dashboard</a></li>
                            @elseif(auth()->user()->role_name === 'Student')
                                <li><a href="{{ route('student/dashboard') }}" class="{{ set_active(['student/dashboard']) }}">Student Dashboard</a></li>
                            @else
                                <li>Rôle inconnu</li>
                            @endif
                        @else
                            <li>Veuillez vous connecter.</li>
                        @endif
                    </ul>
                </li>

                <!-- Admin and Super Admin Menu -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                    <!-- User Management -->
                    <li class="submenu {{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-shield-alt"></i><span>User Management</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('list/users') }}" class="{{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">List Users</a></li>
                        </ul>
                    </li>
                @endif

                <!-- Admin Menu -->
                @if(auth()->user()->role_name === 'Admin')
                    <!-- Students -->
                    <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} {{ (request()->is('student/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-graduation-cap"></i><span>Students</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('student/list') }}"  class="{{set_active(['student/list','student/grid'])}}">Student List</a></li>
                        </ul>
                    </li>

                    <!-- Schedule -->
                    <li class="submenu {{set_active(['subject/list/page','subject/add/page'])}}">
                        <a href="#"><i class="fas fa-book-reader"></i><span>Schedule</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('admin.calendar') }}" class="btn btn-primary mb-3">View Calendar</a></li>
                        </ul>
                    </li>

                    <!-- Subjects -->
                    <li class="submenu {{set_active(['subject/list/page','subject/add/page'])}} {{ request()->is('subject/edit/*') ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-book-reader"></i><span>Subjects</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a class="{{set_active(['subject/list/page'])}} {{ request()->is('subject/edit/*') ? 'active' : '' }}" href="{{ route('subject/list/page') }}">Subject List</a></li>
                            <li><a class="{{set_active(['subject/add/page'])}}" href="{{ route('subject/add/page') }}">Subject Add</a></li>
                            <li><a>Subject Edit</a></li>
                        </ul>
                    </li>

                    <!-- Classes -->
                    <li class="{{set_active(['class/list/page'])}}">
                        <a href="{{ route('class/list/page') }}"><i class="fas fa-book"></i><span>Classes</span></a>
                    </li>
                    <!-- Teachers -->
                    <li class="{{set_active(['teacher/list/page'])}}">
                        <a href="{{ route('teacher/list/page') }}"><i class="fas fa-user"></i><span>Teachers</span></a>
                    </li>


                @endif

                <!-- Teacher Menu -->
                @if(auth()->user()->role_name === 'Teachers')
                    <!-- Students -->
                    <li class="submenu {{set_active(['student/list','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-graduation-cap"></i><span>Students</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('student/list') }}" class="{{set_active(['student/list'])}}">Student List</a></li>
                            <li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>
                        </ul>
                    </li>

                    <!-- Departments -->
                    <li class="submenu {{set_active(['department/list/page','department/add/page'])}}">
                        <a href="#"><i class="fas fa-building"></i><span>Departments</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('department/list/page') }}" class="{{set_active(['department/list/page'])}}">Department List</a></li>
                            <li><a href="{{ route('department/add/page') }}" class="{{set_active(['department/add/page'])}}">Department Add</a></li>
                        </ul>
                    </li>

                    <!-- Subjects -->
                    <li class="submenu {{set_active(['subject/list/page','subject/add/page'])}}">
                        <a href="#"><i class="fas fa-book-reader"></i><span>Subjects</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('subject/list/page') }}" class="{{set_active(['subject/list/page'])}}">Subject List</a></li>
                            <li><a href="{{ route('subject/add/page') }}" class="{{set_active(['subject/add/page'])}}">Subject Add</a></li>
                        </ul>
                    </li>

                    <!-- Schedule -->
                    <li class="submenu {{set_active(['subject/list/page','subject/add/page'])}}">
                        <a href="#"><i class="fas fa-calendar-alt"></i><span>Schedule</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('admin.calendar') }}" class="btn btn-primary mb-3">Afficher le Calendrier</a></li>
                        </ul>
                    </li>



                    <!-- Holiday and Events -->
                    <li><a href="holiday.html"><i class="fas fa-holly-berry"></i><span>Holiday</span></a></li>
                    <li><a href="event.html"><i class="fas fa-calendar-day"></i><span>Events</span></a></li>
                @endif

                <!-- Student Menu -->
                @if(auth()->user()->role_name === 'Student')
                    <!-- Teacher Profile -->
                    <li class="{{ set_active(['student/teacher/*']) }}">
                        <a href="{{ route('student.teacher.profile', auth()->user()->id) }}">
                            <i class="fas fa-user-tie"></i><span>Teacher's Profile</span>
                        </a>
                    </li>


                    <!-- Grades -->
                    <li class="{{ set_active(['student/grades']) }}">
                        <a href="{{ route('grades.show') }}">
                            <i class="fas fa-graduation-cap"></i><span>My Grades</span>
                        </a>
                    </li>

                    <!-- Schedule -->
                    <li class="{{ set_active(['admin.calendar']) }}">
                        <a href="{{ route('admin.calendar') }}">
                            <i class="fas fa-calendar-alt"></i><span>My Schedule</span>
                        </a>
                    </li>



                    <!-- Reservations -->
                    <li>
                        <a href="{{ route('reservations.index') }}"><i class="fas fa-clipboard-list"></i><span>My Reservations</span></a>
                    </li>

{{--                    <!-- Holiday and Events -->--}}
{{--                    <li><a href="holiday.html"><i class="fas fa-holly-berry"></i><span>Holiday</span></a></li>--}}
{{--                    <li><a href="event.html"><i class="fas fa-calendar-day"></i><span>Events</span></a></li>--}}
                @endif

                <!-- Comptable Menu -->
                @if(auth()->user()->role_name === 'Comptable')
                    <!-- Invoices -->
                    <li class="submenu {{set_active(['invoice/list/page','invoice/add/page'])}} {{ request()->is('invoice/edit/*') ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-clipboard"></i><span>Invoices</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('invoice/list/page') }}" class="{{set_active(['invoice/list/page'])}}">Invoices List</a></li>
                            <li><a href="{{ route('invoice/add/page') }}" class="{{set_active(['invoice/add/page'])}}">Add Invoices</a></li>
                        </ul>
                    </li>

                    <!-- Accounts -->
                    <li class="submenu {{set_active(['account/fees/collections/page','add/fees/collection/page'])}}">
                        <a href="#"><i class="fas fa-file-invoice-dollar"></i><span>Accounts</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a class="{{set_active(['account/fees/collections/page'])}}" href="{{ route('account/fees/collections/page') }}">Fees Collection</a></li>
                            <li><a href="expenses.html">Expenses</a></li>
                            <li><a href="salary.html">Salary</a></li>
                            <li><a class="{{set_active(['add/fees/collection/page'])}}" href="{{ route('add/fees/collection/page') }}">Add Fees</a></li>
                            <li><a href="add-expenses.html">Add Expenses</a></li>
                            <li><a href="add-salary.html">Add Salary</a></li>
                        </ul>
                    </li>

                    <!-- Fees -->
                    <li><a href="fees.html"><i class="fas fa-comment-dollar"></i><span>Fees</span></a></li>
                @endif



                <!-- Teacher Space -->
                @if(auth()->user()->role_name === 'Teacher')
                    <li>
                        <a href="{{ route('teacher.space') }}" class="nav-link">
                            <i class="fas fa-user-tie"></i><span>Teacher Space</span>
                        </a>
                    </li>

                    <!-- Schedule -->
                    <li class="submenu {{set_active(['subject/list/page','subject/add/page'])}}">
                        <a href="#"><i class="fas fa-book-reader"></i><span>Schedule</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('admin.calendar') }}" class="btn btn-primary mb-3">Afficher le Calendrier</a></li>
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->role_name === 'Student' || auth()->user()->role_name === 'Librarian')
                <li class="menu-title">
                    <span>Management</span>
                </li>
                <li>
                    {{--                    <a href="library.html"><i class="fas fa-book"></i> <span>Library</span></a>--}}
                    <a href="{{ route('book/list/page') }}"><i class="fas fa-book"></i> <span>Library</span></a>


                </li>
                    <!-- Reservations -->
                    <li>
                        <a href="{{ route('reservations.index') }}"><i class="fas fa-clipboard-list"></i><span>My Reservations</span></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>