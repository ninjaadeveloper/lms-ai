@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Create Quiz</h4>
          <a href="{{ auth()->user()->role==='admin' ? route('admin.quizzes.index') : route('trainer.quizzes.index') }}"
             class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
        </div>

        <div class="card-body">
          <div class="form-group">
            <label>Select Course</label>
            <select id="course_id" class="form-control">
              <option value="">-- Select --</option>
              @foreach($courses as $c)
                <option value="{{ $c->id }}">{{ $c->title }}</option>
              @endforeach
            </select>
          </div>

          <button class="btn btn-primary" id="goBtn">
            <i class="fas fa-bolt mr-1"></i> Continue to Generator
          </button>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
document.getElementById('goBtn').addEventListener('click', function () {
  const id = document.getElementById('course_id').value;
  if (!id) return alert('Please select a course');

  const base = "{{ auth()->user()->role==='admin' ? url('admin') : url('trainer') }}";
  window.location = `${base}/courses/${id}/quizzes/create`;
});
</script>
@endsection
