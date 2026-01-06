@extends('../admin.layout')

@section('content')
<div class="main-content">
<section class="section">

  {{-- HEADER --}}
  <div class="section-header">
    <h1>Quiz Results</h1>
  </div>

  {{-- ================= STAT CARDS ================= --}}
  <div class="row">

    <div class="col-lg-3 col-md-6">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-list"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header"><h4>Total Quizzes</h4></div>
          <div class="card-body">{{ $totalQuizzes }}</div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card card-statistic-1">
        <div class="card-icon bg-info">
          <i class="fas fa-users"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header"><h4>Total Attempts</h4></div>
          <div class="card-body">{{ $totalAttempts }}</div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header"><h4>Active Quizzes</h4></div>
          <div class="card-body">{{ $quizzes->count() }}</div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="fas fa-chart-line"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header"><h4>Avg Attempts / Quiz</h4></div>
          <div class="card-body">
            {{ $totalQuizzes ? round($totalAttempts / $totalQuizzes, 1) : 0 }}
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ================= QUIZ TABLE ================= --}}
  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm">

        <div class="card-header">
          <h4 class="mb-0">Quiz Wise Results</h4>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">

              <thead>
                <tr>
                  <th>#</th>
                  <th>Quiz</th>
                  <th>Course</th>
                  <th>Attempts</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>

              <tbody>
              @forelse($quizzes as $i => $quiz)

                <tr style="cursor:pointer"
                    onclick="window.location='{{ route('admin.quiz.attempts.show', $quiz->id) }}'">

                  <td>{{ $quizzes->firstItem() + $i }}</td>

                  <td>
                    <strong>{{ $quiz->topic }}</strong><br>
                    <small class="text-muted">
                      Created {{ $quiz->created_at->diffForHumans() }}
                    </small>
                  </td>

                  <td>
                    <span class="badge badge-light">
                      {{ $quiz->course->title ?? '-' }}
                    </span>
                  </td>

                  <td>
                    <span class="badge badge-info">
                      {{ $quiz->attempts_count }} Attempts
                    </span>
                  </td>

                  <td class="text-center" onclick="event.stopPropagation();">
                    <a href="{{ route('admin.quiz.attempts.show', $quiz->id) }}"
                       class="btn btn-sm btn-primary">
                      <i class="fas fa-eye"></i> View
                    </a>
                  </td>

                </tr>

              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">
                    No quizzes found.
                  </td>
                </tr>
              @endforelse
              </tbody>

            </table>
          </div>
        </div>

        <div class="card-footer text-right">
          {{ $quizzes->links() }}
        </div>

      </div>
    </div>
  </div>

</section>
</div>
@endsection
