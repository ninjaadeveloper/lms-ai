@extends('../admin.layout')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h4 class="mb-1">Quiz Details</h4>
            <div class="text-muted">
              Course: <strong>{{ $quiz->course->title ?? '—' }}</strong> |
              Topic: <strong>{{ $quiz->topic ?? ($quiz->title ?? '-') }}</strong> |
              Total: <span class="badge badge-light">{{ $quiz->total_questions ?? 0 }}</span>
            </div>
          </div>

          <div>
            <a href="{{ route('trainer.quizzes.index') }}" class="btn btn-light">
              <i class="fas fa-arrow-left mr-1"></i> Back
            </a>

            {{-- Trainer delete only if trainer created it --}}
            <!-- @if(($quiz->creator_role ?? '') === 'trainer' && ($quiz->created_by ?? null) == auth()->id())
              <form action="{{ route('trainer.quizzes.destroy', $quiz->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Delete this quiz?')">
                  <i class="fas fa-trash mr-1"></i> Delete
                </button>
              </form>
            @endif -->
          </div>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-header">
          <h5 class="mb-0">Questions</h5>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
              <thead>
                <tr>
                  <th style="width:70px;">#</th>
                  <th>Question</th>
                </tr>
              </thead>
              <tbody>
                @forelse($quiz->questions as $i => $q)
                  <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                      <div class="font-weight-bold">{{ $q->question }}</div>

                      <div class="text-muted mt-2">
                        <div><strong>A:</strong> {{ $q->option_a }}</div>
                        <div><strong>B:</strong> {{ $q->option_b }}</div>
                        <div><strong>C:</strong> {{ $q->option_c }}</div>
                        <div><strong>D:</strong> {{ $q->option_d }}</div>

                        <div class="mt-2">
                          <span class="badge badge-light">
                            Correct: {{ strtoupper($q->correct_option) }}
                          </span>
                        </div>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="2" class="text-center text-muted py-4">No questions found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      </div>

    </div>
  </section>
</div>
@endsection
