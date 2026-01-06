@extends('admin.layout')

@section('content')
  <div class="main-content">
    <section class="section">

      {{-- HEADER --}}
      <div class="section-header">
        <h1>{{ $quiz->topic }} – Quiz Results</h1>
      </div>

      {{-- ================= STATS CARDS ================= --}}
      @php
        $totalAttempts = $attempts->count();
        $passCount = $attempts->where('score_percent', '>=', 50)->count();
        $failCount = $totalAttempts - $passCount;
        $avgScore = $totalAttempts ? round($attempts->avg('score_percent')) : 0;
      @endphp

      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Attempts</h4>
              </div>
              <div class="card-body">{{ $totalAttempts }}</div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card card-statistic-1">
            <div class="card-icon bg-info">
              <i class="fas fa-percentage"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Average Score</h4>
              </div>
              <div class="card-body">{{ $avgScore }}%</div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Passed</h4>
              </div>
              <div class="card-body">{{ $passCount }}</div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-times-circle"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Failed</h4>
              </div>
              <div class="card-body">{{ $failCount }}</div>
            </div>
          </div>
        </div>

      </div>

      {{-- ================= TABLE ================= --}}
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">

            <div class="card-header">
              <h4 class="mb-0">Student Attempts</h4>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Student</th>
                      <th>Score</th>
                      <th>Status</th>
                      <th>Submitted</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($attempts as $i => $a)
                                      @php $pass = $a->score_percent >= 50; @endphp

                                      {{-- ROW CLICK --}}
                                      <tr style="cursor:pointer" onclick="window.location='{{ route(
                        'admin.quiz.attempts.student.detail',
                        [$quiz->id, $a->id]
                      ) }}'">

                                        <td>{{ $i + 1 }}</td>

                                        <td>
    <strong>{{ $a->student->name }}</strong>

    @if($i === 0)
        <span class="badge badge-warning ml-2">🥇 Rank 1</span>
    @elseif($i === 1)
        <span class="badge badge-secondary ml-2">🥈 Rank 2</span>
    @elseif($i === 2)
        <span class="badge badge-dark ml-2">🥉 Rank 3</span>
    @endif

    <br>
    <small class="text-muted">{{ $a->student->email }}</small>
</td>


                                        <td>
                                          <span class="badge badge-primary p-2">
                                            {{ $a->score_percent }}%
                                          </span>
                                        </td>

                                        <td>
                                          <span class="badge badge-{{ $pass ? 'success' : 'danger' }}">
                                            {{ $pass ? 'Pass' : 'Fail' }}
                                          </span>
                                        </td>

                                        <td>
                                          {{ optional($a->submitted_at)->format('d M Y') }}<br>
                                          <!-- <small class="text-muted">
                                                              {{ optional($a->submitted_at)->format('h:i A') }}
                                                            </small> -->
                                        </td>

                                        <td class="text-center" onclick="event.stopPropagation();">
                                          <a href="{{ route(
                        'admin.quiz.attempts.student.detail',
                        [$quiz->id, $a->id]
                      ) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View Result
                                          </a>
                                        </td>

                                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                          <i class="fas fa-inbox fa-2x mb-2"></i>
                          <div>No attempts found for this quiz.</div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>

                </table>
              </div>
            </div>

          </div>
        </div>
      </div>

    </section>
  </div>
@endsection