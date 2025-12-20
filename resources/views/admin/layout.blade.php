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
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="{{ asset('assets//img/user.png') }}"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello Sarah Smith</div>
              <a href="profile.html" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a> 
              <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="auth-login.html" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#"> <img alt="image" src="{{ asset('assets//img/logo.png') }}" class="header-logo" /> <span
                class="logo-name">LMS - AI</span>
            </a>
          </div>
        <ul class="sidebar-menu">

  <!-- Dashboard -->
  <li class="menu-header">Dashboard</li>
  <li class="dropdown">
    <a href="{{ route('admin.dashboard') }}" class="nav-link">
      <i data-feather="monitor"></i><span>Dashboard</span>
    </a>
  </li>

  <!-- Users -->
  <li class="dropdown">
    <a href="#" class="menu-toggle nav-link has-dropdown">
      <i data-feather="users"></i><span>Users</span>
    </a>
    <ul class="dropdown-menu">
      <li><a class="nav-link" href="{{ route('users.index') }}">All Users</a></li>
      <li><a class="nav-link" href="{{ route('users.create') }}">Add User</a></li>
      <li><a class="nav-link" href="{{ route('users.trainers') }}">Trainers</a></li>
      <li><a class="nav-link" href="{{ route('users.students') }}">Students</a></li>
    </ul>
  </li>

  <!-- Courses -->
  <li class="dropdown">
    <a href="#" class="menu-toggle nav-link has-dropdown">
      <i data-feather="book"></i><span>Courses</span>
    </a>
    <ul class="dropdown-menu">
      <li><a class="nav-link" href="{{ route('courses.index') }}">Course List</a></li>
      <li><a class="nav-link" href="{{ route('courses.create') }}">Add Course</a></li>
    </ul>
  </li>

  <!-- Quizzes -->
  <li class="dropdown">
    <a href="#" class="menu-toggle nav-link has-dropdown">
      <i data-feather="book-open"></i><span>Quizzes</span>
    </a>
    <ul class="dropdown-menu">
      <li><a class="nav-link" href="{{ route('quizzes.index') }}">Quiz List</a></li>
      <li><a class="nav-link" href="{{ route('quizzes.create') }}">Add Quiz</a></li>
      <li><a class="nav-link" href="{{ route('quizzes.index') }}">Quiz Results</a></li>
    </ul>
  </li>

  <!-- AI Assistant -->
  <li class="dropdown">
    <a href="{{ route('ai.studentPerformance') }}" class="nav-link">
      <i data-feather="cpu"></i><span>AI Assistant</span>
    </a>
  </li>

  <!-- Feedback -->
  <li class="dropdown">
    <a href="{{ route('feedback.index') }}" class="nav-link">
      <i data-feather="message-square"></i><span>Feedback</span>
    </a>
  </li>

  <!-- Settings -->
  <li class="dropdown">
    <a href="#" class="menu-toggle nav-link has-dropdown">
      <i data-feather="settings"></i><span>Settings</span>
    </a>
    <ul class="dropdown-menu">
      <li><a class="nav-link" href="#">Profile</a></li>
      <li><a class="nav-link" href="#">Change Password</a></li>
    </ul>
  </li>

  <!-- Logout -->
  <li class="dropdown">
    <a href="#" class="nav-link">
      <i data-feather="log-out"></i><span>Logout</span>
    </a>
  </li>

         </ul>
        </aside>
      </div>

    @yield('content')

      <footer class="main-footer">
        <div class="footer-left">
          <a href="Lms-AI.net">Lms-AI</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
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