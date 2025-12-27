@extends('../admin.layout')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Select Course</h4>
              <a href="{{ route('trainer.quizzes.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to Quizzes
              </a>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th style="width:70px;">#</th>
                      <th>Course</th>
                      <th class="text-center" style="width:220px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($courses as $i => $course)
                      <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                          <strong>{{ $course->title }}</strong>
                          <br><small class="text-muted">Course ID: {{ $course->id }}</small>
                        </td>
                        <td class="text-center">
                          <a href="{{ route('trainer.courses.quizzes.create', $course->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-magic mr-1"></i> Generate Quiz
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3" class="text-center text-muted py-4">No courses found.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            <!-- <div class="card-footer text-right">
              <small class="text-muted">Trainer ko sirf apne courses show honge.</small>
            </div> -->

          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
