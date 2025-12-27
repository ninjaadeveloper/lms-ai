@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Quiz Result</h1>
    </div>

    <div class="section-body">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-start flex-wrap">
          <div class="mb-3 mb-md-0">
            <h4 class="mb-1">{{ $quiz->topic ?? 'Quiz' }}</h4>
            <div class="text-muted">
              Course: <strong>{{ $quiz->course->title ?? '-' }}</strong>
            </div>
          </div>

          {{-- ✅ Right badges --}}
          <div class="text-right">
            <div class="d-flex justify-content-end flex-wrap" style="gap:8px;">
              <span class="badge badge-primary p-2">
                Rank: <strong>#{{ $rank }}</strong> / {{ $totalAttempts }}
              </span>
              <span class="badge badge-dark p-2">
                Attempt: <strong>#{{ $attemptNo }}</strong>
              </span>

              @if($isPass)
                <span class="badge badge-success p-2">PASS</span>
              @else
                <span class="badge badge-danger p-2">FAIL</span>
              @endif
            </div>

            <div class="mt-2">
              <span class="badge badge-light p-2">
                Date: <strong>{{ optional($attempt->submitted_at)->format('d M Y') }}</strong>
              </span>
            </div>

            <!-- <div class="mt-2">
              <span class="badge badge-light p-2">
                Time: <strong>{{ optional($attempt->submitted_at)->format('h:i A') }}</strong>
              </span>
            </div> -->
          </div>
        </div>

        <div class="card-body pt-0">
          <div class="row align-items-center">
            {{-- ✅ Circular Score --}}
            <div class="col-md-4 mb-3">
              @php $score = (int)($attempt->score_percent ?? 0); @endphp
              <div class="p-3 border rounded text-center">
                <div class="mx-auto" style="
                  width:140px;height:140px;border-radius:50%;
                  background: conic-gradient(#6777ef {{ $score }}%, #e9ecef 0);
                  display:flex;align-items:center;justify-content:center;">
                  <div style="width:110px;height:110px;border-radius:50%;background:#fff;
                    display:flex;align-items:center;justify-content:center;flex-direction:column;">
                    <div style="font-size:26px;font-weight:800;">{{ $score }}%</div>
                    <div class="text-muted" style="font-size:12px;">Score</div>
                  </div>
                </div>

                <div class="mt-3">
                  <span class="badge badge-info p-2">
                    Pass Mark: <strong>{{ $passPercent }}%</strong>
                  </span>
                </div>
              </div>
            </div>

            {{-- ✅ Stats cards --}}
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-4 mb-2">
                  <div class="p-3 border rounded">
                    <div class="text-muted">Total Questions</div>
                    <div style="font-size:22px;"><strong>{{ $attempt->total_questions }}</strong></div>
                  </div>
                </div>

                <div class="col-md-4 mb-2">
                  <div class="p-3 border rounded">
                    <div class="text-muted">Correct</div>
                    <div style="font-size:22px;">
                      <span class="badge badge-success p-2">{{ $attempt->correct }}</span>
                    </div>
                  </div>
                </div>

                <div class="col-md-4 mb-2">
                  <div class="p-3 border rounded">
                    <div class="text-muted">Wrong</div>
                    <div style="font-size:22px;">
                      <span class="badge badge-danger p-2">{{ $attempt->wrong }}</span>
                    </div>
                  </div>
                </div>

                <div class="col-12 mt-2">
                  <div class="p-3 border rounded">
                    <div class="text-muted mb-1">Performance</div>
                    <div class="progress" style="height:10px;">
                      <div class="progress-bar" role="progressbar"
                           style="width: {{ $score }}%;"
                           aria-valuenow="{{ $score }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted d-block mt-2">
                      {{ $isPass ? 'Nice! You passed.' : 'Keep practicing, you will improve.' }}
                    </small>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap" style="gap:10px;">
          <a href="{{ route('student.quizzes.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left mr-1"></i> Back to Quizzes
          </a>

          <div class="d-flex flex-wrap" style="gap:10px;">
            <a href="{{ route('student.quizzes.result.pdf', $quiz->id) }}" class="btn btn-outline-danger">
              <i class="fas fa-file-pdf mr-1"></i> Download PDF
            </a>

            <a href="{{ route('student.quizzes.result.detail', $quiz->id) }}" class="btn btn-primary">
              <i class="fas fa-list mr-1"></i> View Details
            </a>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
