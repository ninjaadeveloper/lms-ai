@extends('admin.layout')

@section('content')
  <style>
    .dash-title {
      font-size: 22px;
      font-weight: 700;
    }

    .mini-muted {
      font-size: 12px;
      opacity: .75;
    }

    .stat-card {
      border-radius: 14px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
    }

    .stat-card .card-body {
      padding: 18px 18px;
    }

    .stat-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(103, 119, 239, .12);
    }

    .stat-icon svg {
      width: 22px;
      height: 22px;
    }

    .chart-card {
      border-radius: 14px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
    }

    .chart-box {
      min-height: 320px;
    }

    .chart-sm {
      min-height: 240px;
    }

    .table td,
    .table th {
      vertical-align: middle !important;
    }

    .click-row {
      cursor: pointer;
    }

    .click-row:hover {
      background: #f7f9ff;
    }

    .avatar-circle {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 13px;
      color: #fff;
      background: #6777ef;
    }

    #userChart {
      height: 430px !important;
    }

    .quiz-card-body {
      padding-top: 10px !important;
      padding-bottom: 5px !important;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }

    /* Apex chart container extra gap remove */
    #quizChart {
      height: 370px !important;
      margin-top: -10px;
      margin-bottom: -20px;
      /* 👈 this removes lower gap */
    }

    /* Legend ko tight karo */
    #quizChart .apexcharts-legend {
      margin-top: -10px !important;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }

    /* SVG bottom whitespace */
    #quizChart .apexcharts-svg {
      overflow: visible !important;
    }
  </style>

  <div class="main-content">
    <section class="section">
      <div class="section-body">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <div class="dash-title">Dashboard</div>
            <small class="text-muted">Logged in as: <b class="text-uppercase">{{ $role }}</b></small>
          </div>
        </div>

        {{-- ================= ADMIN ================= --}}
        @if($role === 'admin')

          {{-- TOP STATS --}}
          <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Total Users</div>
                    <div style="font-size:26px;font-weight:800;">{{ $totalUsers ?? 0 }}</div>
                    <div class="mini-muted">Live system count</div>
                  </div>
                  <div class="stat-icon"><i data-feather="users"></i></div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Trainers</div>
                    <div style="font-size:26px;font-weight:800;">{{ $totalTrainers ?? 0 }}</div>
                    <div class="mini-muted">Role count</div>
                  </div>
                  <div class="stat-icon"><i data-feather="user-check"></i></div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Students</div>
                    <div style="font-size:26px;font-weight:800;">{{ $totalStudents ?? 0 }}</div>
                    <div class="mini-muted">Role count</div>
                  </div>
                  <div class="stat-icon"><i data-feather="user"></i></div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Courses</div>
                    <div style="font-size:26px;font-weight:800;">{{ $totalCourses ?? 0 }}</div>
                    <div class="mini-muted">Available courses</div>
                  </div>
                  <div class="stat-icon"><i data-feather="book-open"></i></div>
                </div>
              </div>
            </div>
          </div>

          {{-- MAIN ACTIVITY + DONUT --}}
          <div class="row">
            <div class="col-lg-8 mb-3">
              <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="mb-0">Users Data (Monthly) </h4>
                </div>
                <div class="card-body">
                  <div id="chart1" class="chart-box"></div>
                  <div class="row text-center mt-3">
                    <div class="col">
                      <div class="mini-muted">Admins</div>
                      <div class="font-weight-bold">{{ $totalUsers - $totalTrainers - $totalStudents }}</div>
                    </div>
                    <div class="col">
                      <div class="mini-muted">Trainers</div>
                      <div class="font-weight-bold">{{ $totalTrainers }}</div>
                    </div>
                    <div class="col">
                      <div class="mini-muted">Students</div>
                      <div class="font-weight-bold">{{ $totalStudents }}</div>
                    </div>
                    <div class="col">
                      <div class="mini-muted">Total Users</div>
                      <div class="font-weight-bold">{{ $totalUsers }}</div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-3">
              <div class="card chart-card">

                <div class="card-header">
                  <h4 class="mb-0">Users (Active vs Inactive)</h4>
                </div>

                <div class="card-body justify-content-between" id="userChart">

                  <!-- Donut Chart -->
                  <div id="chart2" class="chart-sm mb-0"></div>

                  <!-- One line summary -->
                  <div class="row text-center mt-4">
                    <div class="col-4">
                      <small class="text-muted">Active</small>
                      <div class="h5 text-success mb-0">{{ $activeUsers }}</div>
                    </div>
                    <div class="col-4">
                      <small class="text-muted">Inactive</small>
                      <div class="h5 text-danger mb-0">{{ $inactiveUsers }}</div>
                    </div>
                    <div class="col-4">
                      <small class="text-muted">Total</small>
                      <div class="h5 mb-0">{{ $totalUsers }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          {{-- ✅ 1 ROW: Courses Status + Role Distribution (Weekly) --}}
          <div class="row">
            <div class="col-lg-8 mb-3">
              <div class="card chart-card">
                <div class="card-header">
                  <h4 class="mb-0">Courses (Weekly Active vs Inactive)</h4>
                </div>
                <div class="card-body">
                  <div id="courseChart" style="height:300px;"></div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-3">
              <div class="card chart-card">
                <div class="card-header">
                  <h4 class="mb-0">Quizzes Overview</h4>
                </div>

                <div class="card-body quiz-card-body">
                  <div id="quizChart"></div>
                </div>
              </div>

            </div>



          </div>


          {{-- TABLES --}}
          <div class="row">
            <div class="col-lg-6 mb-3">
              <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="mb-0">Recent Users</h4>
                  <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">View All</a>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped mb-0">
                      <thead>
                        <tr>
                          <th>User</th>
                          <th>Role</th>
                          <th class="text-right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse(($recentUsers ?? []) as $u)
                          {{-- ✅ FIXED: admin.users.show --}}
                          <tr class="click-row" onclick="window.location='{{ route('admin.users.show', $u->id) }}'">
                            <td>
                              <div class="d-flex align-items-center">
                                <div class="avatar-circle mr-3">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                                <div>
                                  <div class="font-weight-bold">{{ $u->name }}</div>
                                  <div class="mini-muted">{{ $u->email }}</div>
                                </div>
                              </div>
                            </td>
                            <td><span class="badge badge-light text-uppercase">{{ $u->role }}</span></td>
                            <td class="text-right">
                              <a href="{{ route('admin.users.show', $u->id) }}" class="btn btn-sm btn-outline-primary"
                                onclick="event.stopPropagation()">Details</a>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="3" class="text-center py-4">No users found</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mb-3">
              <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="mb-0">Recent Courses</h4>
                  {{-- ✅ FIXED: admin.courses.index --}}
                  <a href="{{ route('admin.courses.index') }}" class="btn btn-info btn-sm">View All</a>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped mb-0">
                      <thead>
                        <tr>
                          <th>Course</th>
                          <th>Status</th>
                          <th class="text-right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse(($recentCourses ?? []) as $c)
                                        {{-- ✅ FIXED: admin.courses.show --}}
                                        <tr class="click-row" onclick="window.location='{{ route('admin.courses.show', $c->id) }}'">
                                          <td>
                                            <div class="font-weight-bold">{{ $c->title }}</div>
                                            <div class="mini-muted">{{ \Illuminate\Support\Str::limit($c->description, 55) }}</div>
                                          </td>
                                          <td>
                                            {!! ($c->status ?? 0)
                          ? '<span class="badge badge-success">Active</span>'
                          : '<span class="badge badge-danger">Inactive</span>' !!}
                                          </td>
                                          <td class="text-right">
                                            <a href="{{ route('admin.courses.show', $c->id) }}" class="btn btn-sm btn-outline-info"
                                              onclick="event.stopPropagation()">Detail</a>
                                          </td>
                                        </tr>
                        @empty
                          <tr>
                            <td colspan="3" class="text-center py-4">No courses found</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        @endif

        {{-- ================= TRAINER ================= --}}
        @if($role === 'trainer')

          <div class="row">
            <div class="col-lg-4 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">My Courses</div>
                    <div style="font-size:26px;font-weight:800;">{{ $myCoursesCount ?? 0 }}</div>
                    <div class="mini-muted">Total assigned</div>
                  </div>
                  <div class="stat-icon"><i data-feather="book"></i></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Active Courses</div>
                    <div style="font-size:26px;font-weight:800;">{{ $myActiveCount ?? 0 }}</div>
                    <div class="mini-muted">Currently running</div>
                  </div>
                  <div class="stat-icon"><i data-feather="activity"></i></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">My Feedback</div>
                    <div style="font-size:26px;font-weight:800;">{{ $myFeedbackCount ?? 0 }}</div>
                    <div class="mini-muted">Submitted</div>
                  </div>
                  <div class="stat-icon"><i data-feather="message-square"></i></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 mb-3">
              <div class="card chart-card">
                <div class="card-header">
                  <h4 class="mb-0">My Courses (Monthly)</h4>
                </div>
                <div class="card-body">
                  <div id="tchart1" class="chart-sm"></div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mb-3">
              <div class="card chart-card">
                <div class="card-header">
                  <h4 class="mb-0">My Quizzes (Course wise)</h4>
                </div>
                <div class="card-body">
                  <div id="tchart2" class="chart-sm"></div>
                </div>
              </div>
            </div>
          </div>


          <div class="card chart-card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0">My Recent Courses</h4>
              <a href="{{ route('trainer.courses.index') }}" class="btn btn-info btn-sm">All Courses</a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped mb-0">
                  <thead>
                    <tr>
                      <th>Course</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse(($myCourses ?? []) as $c)
                                <tr class="click-row" onclick="window.location='{{ route('trainer.courses.show', $c->id) }}'">
                                  <td>
                                    <div class="font-weight-bold">{{ $c->title }}</div>
                                    <div class="mini-muted">{{ \Illuminate\Support\Str::limit($c->description, 60) }}</div>
                                  </td>
                                  <td>
                                    {!! ($c->status ?? 0)
                      ? '<span class="badge badge-success">Active</span>'
                      : '<span class="badge badge-danger">Inactive</span>' !!}
                                  </td>
                                </tr>
                    @empty
                      <tr>
                        <td colspan="2" class="text-center py-4">No courses found</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        @endif

        {{-- ================= STUDENT ================= --}}
        @if($role === 'student')

          <div class="row">
            <div class="col-lg-4 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Enrolled Courses</div>
                    <div style="font-size:26px;font-weight:800;">{{ $enrolledCount ?? 0 }}</div>
                    <div class="mini-muted">Total enrolled</div>
                  </div>
                  <div class="stat-icon"><i data-feather="clipboard"></i></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Active Enrollments</div>
                    <div style="font-size:26px;font-weight:800;">{{ $activeEnrollCount ?? 0 }}</div>
                    <div class="mini-muted">Active courses</div>
                  </div>
                  <div class="stat-icon"><i data-feather="zap"></i></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-3">
              <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">My Feedback</div>
                    <div style="font-size:26px;font-weight:800;">{{ $myFeedbackCount ?? 0 }}</div>
                    <div class="mini-muted">Submitted</div>
                  </div>
                  <div class="stat-icon"><i data-feather="message-circle"></i></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 mb-3">
              <div class="card chart-card">
                <div class="card-header">
                  <h4 class="mb-0">My Enrolled Courses (Monthly)</h4>
                </div>
                <div class="card-body">
                  <div id="schart1" class="chart-sm"></div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mb-3">
              <div class="card chart-card">
                <div class="card-header">
                  <h4 class="mb-0">My Quizzes (Monthly)</h4>
                </div>
                <div class="card-body">
                  <div id="schart2" class="chart-sm"></div>
                </div>
              </div>
            </div>
          </div>


          <div class="card chart-card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0">My Courses</h4>
              <a href="{{ route('student.courses.index') }}" class="btn btn-info btn-sm">Browse Courses</a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped mb-0">
                  <thead>
                    <tr>
                      <th>Course</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse(($enrolledCourses ?? []) as $c)
                                <tr class="click-row" onclick="window.location='{{ route('student.courses.show', $c->id) }}'">
                                  <td>
                                    <div class="font-weight-bold">{{ $c->title }}</div>
                                    <div class="mini-muted">{{ \Illuminate\Support\Str::limit($c->description, 60) }}</div>
                                  </td>
                                  <td>
                                    {!! ($c->status ?? 0)
                      ? '<span class="badge badge-success">Active</span>'
                      : '<span class="badge badge-danger">Inactive</span>' !!}
                                  </td>
                                </tr>
                    @empty
                      <tr>
                        <td colspan="2" class="text-center py-4">No enrollments</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        @endif

      </div>
    </section>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>

  <script>
    @if($role === 'admin')
      const labels = @json($labels ?? []);
      const usersByRole = @json($usersByRole ?? null);

      if (usersByRole) {
        new ApexCharts(document.querySelector("#chart1"), {
          chart: { type: 'area', height: 320 },
          series: [
            { name: 'Admins', data: usersByRole.admin },
            { name: 'Trainers', data: usersByRole.trainer },
            { name: 'Students', data: usersByRole.student }
          ],
          xaxis: { categories: labels },
          stroke: { curve: 'smooth', width: 3 },
          dataLabels: { enabled: false },
          tooltip: {
            y: { formatter: v => Math.round(v) + " users" }
          }
        }).render();
      }

      const activeUsers = {{ $activeUsers ?? 0 }};
      const inactiveUsers = {{ $inactiveUsers ?? 0 }};

      if (activeUsers > 0 || inactiveUsers > 0) {
        new ApexCharts(document.querySelector("#chart2"), {
          chart: { type: 'donut', height: 300 },
          series: [activeUsers, inactiveUsers],
          labels: ['Active Users', 'Inactive Users'],
          dataLabels: {
            enabled: true,
            formatter: val => val.toFixed(1) + "%"
          },
          tooltip: {
            y: { formatter: val => val + " users" }
          },
          legend: { position: 'bottom' }
        }).render();
      }

      // Courses
      const courseActive = @json($courseActive ?? []);
      const courseInactive = @json($courseInactive ?? []);

      new ApexCharts(document.querySelector("#courseChart"), {
        chart: { type: 'bar', height: 300, stacked: true },
        series: [
          { name: 'Active Courses', data: courseActive },
          { name: 'Inactive Courses', data: courseInactive }
        ],
        xaxis: { categories: labels }
      }).render();

      // Quizzes (ADMIN ONLY)
      const quizLabels = @json($quizLabels ?? []);
      const quizSeries = @json($quizSeries ?? []);

      if (quizSeries.length > 0) {
        new ApexCharts(document.querySelector("#quizChart"), {
          chart: { type: 'donut', height: 360 },
          series: quizSeries,
          labels: quizLabels,
          legend: { position: 'bottom' }
        }).render();
      }
    @endif

      @if($role === 'trainer')

        const tlabels = @json($tlabels);

        // Chart 1 — Courses (Admin style)
        new ApexCharts(document.querySelector("#tchart1"), {
          chart: { type: 'area', height: 260 },
          series: [
            { name: 'Active Courses', data: @json($tCourseActive) },
            { name: 'Inactive Courses', data: @json($tCourseInactive) }
          ],
          xaxis: { categories: tlabels },
          stroke: { curve: 'smooth', width: 3 },
          dataLabels: { enabled: false }
        }).render();

        // Chart 2 — Quizzes (Trainer ke apne)
        new ApexCharts(document.querySelector("#tchart2"), {
          chart: { type: 'line', height: 260 },
          series: [
            { name: 'My Quizzes', data: @json($tQuizSeries) }
          ],
          xaxis: { categories: tlabels },
          stroke: { curve: 'smooth', width: 3 },
          markers: { size: 5 },
          dataLabels: { enabled: false }
        }).render();

      @endif

      @if($role === 'student')
        const slabels = @json($slabels);
        const schart1 = @json($schart1);
        const schart2 = @json($schart2);

        /* ================= LEFT : Enrolled Courses (AREA) ================= */
        new ApexCharts(document.querySelector("#schart1"), {
          chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false }
          },
          series: [{ name: 'Enrolled Courses', data: schart1 }],
          colors: ['#6777ef'],
          stroke: { curve: 'smooth', width: 3 },
          fill: {
            type: 'gradient',
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.4,
              opacityTo: 0.05
            }
          },
          markers: { size: 0 },
          xaxis: { categories: slabels },
          dataLabels: { enabled: false },
          grid: { strokeDashArray: 4 },
          tooltip: { y: { formatter: v => v + " courses" } }
        }).render();


        /* ================= RIGHT : My Quizzes (LINE) ================= */
        new ApexCharts(document.querySelector("#schart2"), {
          chart: {
            type: 'line',
            height: 300,
            toolbar: { show: false }
          },
          series: [{ name: 'My Quizzes', data: schart2 }],
          colors: ['#1e88ff'],
          stroke: { curve: 'smooth', width: 3 },
          markers: {
            size: 6,
            colors: ['#1e88ff'],
            strokeColors: '#fff',
            strokeWidth: 2,
            hover: { size: 8 }
          },
          xaxis: { categories: slabels },
          dataLabels: { enabled: false },
          grid: { strokeDashArray: 4 },
          tooltip: { y: { formatter: v => v + " quizzes" } }
        }).render();
      @endif




  </script>

@endpush