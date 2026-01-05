@extends('admin.layout')

@section('content')
<div class="main-content">
<section class="section">

  {{-- Header --}}
  <div class="section-header">
    <h1>{{ $quiz->topic }} – Quiz Attempts</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Quiz Results</div>
    </div>
  </div>

  <div class="section-body">

    {{-- Quiz Info Card --}}
    <div class="card shadow-sm mb-4">
      <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h5 class="mb-1">{{ $quiz->topic }}</h5>
          <div class="text-muted">
            Course: <strong>{{ $quiz->course->title ?? '-' }}</strong>
          </div>
          <div class="text-muted">
            Total Questions: {{ $quiz->total_questions }}
          </div>
        </div>

        <div class="text-right mt-3 mt-md-0">
          <span class="badge badge-primary p-2">
            Total Attempts: {{ $attempts->total() }}
          </span>
        </div>
      </div>
    </div>

    {{-- Attempts Table --}}
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Student Attempts</h4>

        {{-- Search --}}
        <form method="GET" class="form-inline">
          <div class="input-group">
            <input type="text"
                   name="student"
                   value="{{ request('student') }}"
                   class="form-control"
                   placeholder="Search student name/email">
            <div class="input-group-append">
              <button class="btn btn-primary">
                <i class="fas fa-search"></i>
              </button>
              <a href="{{ url()->current() }}"
                 class="btn btn-light"
                 title="Reset">
                <i class="fas fa-redo"></i>
              </a>
            </div>
          </div>
        </form>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-striped mb-0">
            <thead>
              <tr>
                <th>#</th>
                <th>Student</th>
                <th>Correct</th>
                <th>Wrong</th>
                <th>Score</th>
                <th>Status</th>
                <th>Submitted</th>
              </tr>
            </thead>

            <tbody>
            @forelse($attempts as $i => $attempt)
              @php
                $score = (int) $attempt->score_percent;
                $pass = $score >= 50;
              @endphp

              <tr>
                <td>{{ $attempts->firstItem() + $i }}</td>

                <td>
                  <div class="font-weight-bold">
                    {{ $attempt->student->name ?? '-' }}
                  </div>
                  <div class="text-muted" style="font-size:12px;">
                    {{ $attempt->student->email ?? '' }}
                  </div>
                </td>

                <td>
                  <span class="badge badge-success">
                    {{ $attempt->correct }}
                  </span>
                </td>

                <td>
                  <span class="badge badge-danger">
                    {{ $attempt->wrong }}
                  </span>
                </td>

                <td>
                  <span class="badge badge-primary p-2">
                    {{ $score }}%
                  </span>
                </td>

                <td>
                  @if($pass)
                    <span class="badge badge-success">Pass</span>
                  @else
                    <span class="badge badge-danger">Fail</span>
                  @endif
                </td>

                <td>
                  <div>{{ optional($attempt->submitted_at)->format('d M Y') }}</div>
                  <div class="text-muted" style="font-size:12px;">
                    {{ optional($attempt->submitted_at)->format('h:i A') }}
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-5">
                  <i class="fas fa-inbox fa-2x mb-2"></i>
                  <div>No attempts found for this quiz.</div>
                </td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- Pagination --}}
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
