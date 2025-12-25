<!DOCTYPE html>
<html lang="en">


<!-- blank.html  21 Nov 2019 03:54:41 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>LMS - AI</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.ico') }}" />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            {{-- Search bar --}}
            {{-- <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li> --}}
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex align-items-center">

              {{-- Letter Avatar --}}
              <div class="user-avatar mr-2">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
              </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right pullDown">

              <div class="dropdown-title">
                Hello {{ auth()->user()->name }}
              </div>

              {{-- Profile --}}
              <a href="{{ route('profile.edit') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>

              <div class="dropdown-divider"></div>

              {{-- Logout --}}
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item has-icon text-danger"
                  style="background:none;border:none;width:100%;text-align:left;">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </button>
              </form>

            </div>
          </li>
        </ul>
      </nav>


      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#">
              <img alt="image" src="{{ asset('assets/img/logo.png') }}" class="header-logo" />
              <span class="logo-name">LMS - AI</span>
            </a>
          </div>

          @php $role = auth()->user()->role ?? 'student'; @endphp

          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            {{-- Dashboard --}}
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('dashboard') }}">
                <i data-feather="monitor"></i><span>Dashboard</span>
              </a>
            </li>

            {{-- ADMIN ONLY: Users dropdown --}}
            @if($role === 'admin')
              <li class="dropdown {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                  <i data-feather="users"></i><span>Users</span>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('admin.users.index') }}">All Users</a></li>
                  <li><a class="nav-link" href="{{ route('admin.users.create') }}">Add User</a></li>
                  <li><a class="nav-link" href="{{ route('admin.users.trainers') }}">Trainers</a></li>
                  <li><a class="nav-link" href="{{ route('admin.users.students') }}">Students</a></li>
                </ul>
              </li>
            @endif

            {{-- COURSES --}}
            @if($role === 'admin')
              {{-- ✅ ADMIN dropdown --}}
              <li class="dropdown {{ request()->routeIs('admin.courses.*', 'admin.enrollments.*') ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                  <i data-feather="book-open"></i><span>Courses</span>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('admin.courses.index') }}">Course List</a></li>
                  <li><a class="nav-link" href="{{ route('admin.courses.create') }}">Add Course</a></li>

                  {{-- ✅ All enrollments list (no param) --}}
                  <li><a class="nav-link" href="{{ route('admin.enrollments.index') }}">Enrollments (All)</a></li>

                  {{-- Optional: only when viewing a course show page --}}
                  @if(request()->routeIs('admin.courses.show') && isset($course))
                    <li>
                      <a class="nav-link" href="{{ route('admin.courses.enrollments', $course->id) }}">
                        This Course Enrollments
                      </a>
                    </li>
                  @endif
                </ul>
              </li>

            @elseif($role === 'trainer')
              {{-- ✅ TRAINER dropdown --}}
              <li class="dropdown {{ request()->routeIs('trainer.courses.*', 'trainer.enrollments.*') ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                  <i data-feather="book-open"></i><span>Courses</span>
                </a>

                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('trainer.courses.index') }}">My Courses</a></li>

                  {{-- ✅ SAFE: trainer enrollments index (NO param) --}}
                  @if(Route::has('trainer.enrollments.index'))
                    <li><a class="nav-link" href="{{ route('trainer.enrollments.index') }}">Enrollments (All)</a></li>
                  @endif

                  {{-- ✅ Course enrollments ONLY when on course show + course exists --}}
                  @if(request()->routeIs('trainer.courses.show') && isset($course) && Route::has('trainer.courses.enrollments'))
                    <li>
                      <a class="nav-link" href="{{ route('trainer.courses.enrollments', $course->id) }}">
                        This Course Enrollments
                      </a>
                    </li>
                  @endif
                </ul>
              </li>

            @else
              {{-- ✅ STUDENT simple --}}
              <li class="{{ request()->routeIs('student.courses.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student.courses.index') }}">
                  <i data-feather="book-open"></i><span>Courses</span>
                </a>
              </li>
            @endif

            {{-- AI Assistant (ALL) --}}
            <li class="{{ request()->routeIs('admin.ai.*', 'trainer.ai.*', 'student.ai.*') ? 'active' : '' }}">
              <a class="nav-link"
                href="{{ $role === 'admin' ? route('admin.ai.index') : ($role === 'trainer' ? route('trainer.ai.index') : route('student.ai.index')) }}">
                <i data-feather="cpu"></i><span>AI Assistant</span>
              </a>
            </li>

            {{-- Feedback (ALL) --}}
            <li
              class="{{ request()->routeIs('admin.feedback.*', 'trainer.feedback.*', 'student.feedback.*') ? 'active' : '' }}">
              <a class="nav-link"
                href="{{ $role === 'admin' ? route('admin.feedback.admin') : ($role === 'trainer' ? route('trainer.feedback.index') : route('student.feedback.index')) }}">
                <i data-feather="message-square"></i><span>Feedback</span>
              </a>
            </li>

            {{-- Settings --}}
            <li class="dropdown {{ request()->routeIs('profile.*', 'password.*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="settings"></i><span>Settings</span>
              </a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('profile.edit') }}">Profile</a></li>
                <li><a class="nav-link" href="{{ route('password.change') }}">Change Password</a></li>
              </ul>
            </li>

            {{-- Logout --}}
            <li>
              <a href="#" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i data-feather="log-out"></i><span>Logout</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
              </form>
            </li>

          </ul>
        </aside>


      </div>





      @yield('content')

      <footer class="main-footer">
        <div class="footer-left">
          <a href="#">Lms-AI</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  @stack('scripts')
  <!-- General JS Scripts -->
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('assets/js/page/index.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>


<!-- blank.html  21 Nov 2019 03:54:41 GMT -->

</html>