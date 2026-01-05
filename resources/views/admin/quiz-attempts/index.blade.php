@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Quiz Results</h1>
      <!-- <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Quiz Results</div>
      </div> -->
    </div>

    <div class="section-body">

      {{-- Flash --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      @endif

      {{-- Stat cards --}}
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary"><i class="fas fa-poll"></i></div>
            <div class="card-wrap">
              <div class="card-header"><h4>Total Attempts</h4></div>
              <div class="card-body">{{ $stats['total'] ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card card-statistic-1">
            <div class="card-icon bg-info"><i class="fas fa-percentage"></i></div>
            <div class="card-wrap">
              <div class="card-header"><h4>Avg Score</h4></div>
              <div class="card-body">{{ $stats['avg'] ?? 0 }}%</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success"><i class="fas fa-check-circle"></i></div>
            <div class="card-wrap">
              <div class="card-header"><h4>Pass</h4></div>
              <div class="card-body">{{ $stats['pass'] ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger"><i class="fas fa-times-circle"></i></div>
            <div class="card-wrap">
              <div class="card-header"><h4>Fail</h4></div>
              <div class="card-body">{{ $stats['fail'] ?? 0 }}</div>
            </div>
          </div>
        </div>
      </div>

      {{-- Filters --}}
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="mb-0">My Course Quiz Results</h4>

          <!-- <form method="GET" class="form-inline">
            <div class="input-group">
              <input type="text" name="student" value="{{ request('student') }}"
                class="form-control" placeholder="Search student name/email">
              <div class="input-group-append">
                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                <a href="{{ url()->current() }}" class="btn btn-light" title="Reset">
                  <i class="fas fa-redo"></i>
                </a>
              </div>
            </div>
          </form> -->
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Student</th>
                  <th>Quiz</th>
                  <th>Course</th>
                  <th>Score</th>
                  <th>Status</th>
                  <th>Submitted</th>
                  <th class="text-right">Action</th>
                </tr>
              </thead>

              <tbody>
                @forelse($attempts as $i => $a)
                  @php
                    $score = (int) ($a->score_percent ?? 0);
                    $pass = $score >= 50; // change threshold if you want
                  @endphp

                  <tr style="cursor:pointer"
                      onclick="window.location='{{ route('trainer.quiz.attempts.show', $a->quiz_id) }}'">
                    <td>{{ $attempts->firstItem() + $i }}</td>

                    <td>
                      <div class="font-weight-bold">{{ $a->student->name ?? '-' }}</div>
                      <div class="text-muted" style="font-size:12px;">{{ $a->student->email ?? '' }}</div>
                    </td>

                    <td class="font-weight-bold">{{ $a->quiz->topic ?? $a->quiz->title ?? 'Quiz' }}</td>

                    <td>{{ $a->quiz->course->title ?? '-' }}</td>

                    <td>
                      <span class="badge badge-primary p-2">{{ $score }}%</span>
                    </td>

                    <td>
                      @if($pass)
                        <span class="badge badge-success">Pass</span>
                      @else
                        <span class="badge badge-danger">Fail</span>
                      @endif
                    </td>

                    <td>
                      <div>{{ optional($a->submitted_at)->format('d M Y') }}</div>
                    </td>

                    <td class="text-right" onclick="event.stopPropagation();">
                      <a href="{{ route('trainer.quiz.attempts.show', $a->quiz_id) }}"
                         class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> View
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                      <i class="fas fa-inbox fa-2x mb-2"></i>
                      <div>No quiz attempts found.</div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        @if(method_exists($attempts, 'links'))
          <div class="card-footer text-right">
            {{ $attempts->links() }}
          </div>
        @endif
      </div>

    </div>
  </section>
</div>
@endsection
