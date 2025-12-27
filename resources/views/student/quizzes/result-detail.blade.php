@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Result Details</h1>
    </div>

    <div class="section-body">

      <div class="card shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
          <div>
            <h4 class="mb-1">{{ $quiz->topic ?? 'Quiz' }}</h4>
            <div class="text-muted">Course: <strong>{{ $quiz->course->title ?? '-' }}</strong></div>
            <div class="text-muted">Score: <strong>{{ $attempt->score_percent ?? 0 }}%</strong></div>
          </div>

          <div class="mt-3 mt-md-0">
            <a href="{{ route('student.quizzes.result', $quiz->id) }}" class="btn btn-light">
              <i class="fas fa-arrow-left mr-1"></i> Back to Result
            </a>
          </div>
        </div>
      </div>

      @foreach($quiz->questions as $idx => $q)
        @php
          $ans = $answersMap[$q->id] ?? null;
          $selected = $ans?->selected_option ? strtoupper($ans->selected_option) : null;
          $correct = $ans?->correct_option ? strtoupper($ans->correct_option) : strtoupper($q->correct_option);
          $isCorrect = $ans?->is_correct ?? false;

          $options = [
            'A' => $q->option_a,
            'B' => $q->option_b,
            'C' => $q->option_c,
            'D' => $q->option_d,
          ];
        @endphp

        <div class="card shadow-sm mb-3">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div>
              <strong>Q{{ $idx+1 }}.</strong> {{ $q->question }}
            </div>

            <div>
              @if($selected)
                @if($isCorrect)
                  <span class="badge badge-success">Correct</span>
                @else
                  <span class="badge badge-danger">Wrong</span>
                @endif
              @else
                <span class="badge badge-warning">Not Answered</span>
              @endif
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              @foreach($options as $key => $text)
                @php
                  $isSelected = ($selected === $key);
                  $isCorrectOpt = ($correct === $key);

                  // styling priority:
                  // correct option -> green border
                  // selected wrong -> red border
                  $boxClass = 'border rounded p-3 mb-2';
                  if ($isCorrectOpt) $boxClass .= ' border-success';
                  if ($isSelected && !$isCorrectOpt) $boxClass .= ' border-danger';
                @endphp

                <div class="col-md-6">
                  <div class="{{ $boxClass }}">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <strong>{{ $key }}:</strong> {{ $text }}
                      </div>

                      <div class="ml-2">
                        @if($isCorrectOpt)
                          <span class="badge badge-success">Correct Answer</span>
                        @endif
                        @if($isSelected)
                          <span class="badge badge-primary">Your Choice</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <hr>
            <div class="text-muted">
              Your Answer: <strong>{{ $selected ?? '-' }}</strong>
              &nbsp; | &nbsp;
              Correct Answer: <strong>{{ $correct ?? '-' }}</strong>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </section>
</div>
@endsection
