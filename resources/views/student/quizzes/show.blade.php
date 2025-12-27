@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h4 class="mb-1">Attempt Quiz</h4>
            <div class="text-muted">
              Course: <strong>{{ $quiz->course?->title }}</strong> —
              Topic: <strong>{{ $quiz->topic }}</strong>
            </div>
          </div>

          <a href="{{ route('student.quizzes.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>

      @if($quiz->questions->count() === 0)
        <div class="alert alert-warning">No questions found in this quiz.</div>
      @else
        <form method="POST" action="{{ route('student.quizzes.submit', $quiz->id) }}">
          @csrf

          <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Questions</h5>
              <span class="badge badge-light">Total: {{ $quiz->questions->count() }}</span>
            </div>

            <div class="card-body">
              @foreach($quiz->questions as $i => $q)
                <div class="mb-4">
                  <div class="font-weight-bold mb-2">{{ $i+1 }}. {{ $q->question }}</div>

                  @php
                    $opts = [
                      'A' => $q->option_a,
                      'B' => $q->option_b,
                      'C' => $q->option_c,
                      'D' => $q->option_d,
                    ];
                  @endphp

                  <div class="row">
                    @foreach($opts as $key => $text)
                      <div class="col-md-6 mb-2">
                        <label class="d-flex align-items-center" style="gap:8px; cursor:pointer;">
                          <input type="radio" name="answers[{{ $q->id }}]" value="{{ $key }}">
                          <span><strong>{{ $key }}:</strong> {{ $text }}</span>
                        </label>
                      </div>
                    @endforeach
                  </div>

                </div>
                <hr>
              @endforeach
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">
              <small class="text-muted">Once submitted, you can view result.</small>
              <button type="submit" class="btn btn-success">
                <i class="fas fa-paper-plane mr-1"></i> Submit Quiz
              </button>
            </div>
          </div>
        </form>
      @endif

    </div>
  </section>
</div>
@endsection
