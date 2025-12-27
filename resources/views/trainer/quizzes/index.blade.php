@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      @endif

      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
              <div>
                <h4 class="mb-0">My Course Quizzes</h4>
                <!-- <small class="text-muted">Trainer ko apne courses ke saare quizzes (admin-created included) show honge.</small> -->
              </div>

              <a href="{{ route('trainer.quizzes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create / Generate Quiz
              </a>
            </div>

            <!-- <div class="card-body">
              <form method="GET" class="row g-2">
                <div class="col-md-5">
                  <label class="small text-muted mb-1">Filter by Course</label>
                  <select name="course_id" class="form-control">
                    <option value="">All Courses</option>
                    @foreach($courses as $c)
                      <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->title }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                  <button class="btn btn-outline-primary">
                    <i class="fas fa-filter mr-1"></i> Apply
                  </button>
                  <a href="{{ route('trainer.quizzes.index') }}" class="btn btn-outline-secondary ml-2">
                    Reset
                  </a>
                </div>
              </form>
            </div> -->

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th style="width:70px;">#</th>
                      <th>Course</th>
                      <th>Topic</th>
                      <th>Total Qs</th>
                      <th>Created By</th>
                      <th>Created</th>
                      <th class="text-center" style="width:140px;">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($quizzes as $key => $quiz)
                      <tr style="cursor:pointer;" onclick="window.location='{{ route('trainer.quizzes.show', $quiz->id) }}'">
                        <td>{{ $quizzes->firstItem() + $key }}</td>

                        <td>
                          <strong>{{ $quiz->course->title ?? '—' }}</strong>
                          @if($quiz->course)
                            <br><small class="text-muted">Course ID: {{ $quiz->course->id }}</small>
                          @endif
                        </td>

                        <td>{{ $quiz->topic ?? ($quiz->title ?? '-') }}</td>

                        <td>
                          <span class="badge badge-light">{{ $quiz->total_questions ?? 0 }}</span>
                        </td>

                        <td>
                          <span class="badge badge-{{ ($quiz->creator_role ?? '') === 'admin' ? 'primary' : 'info' }}">
                            {{ strtoupper($quiz->creator_role ?? 'N/A') }}
                          </span>
                        </td>

                        <td>
                          <small class="text-muted">
                            {{ optional($quiz->created_at)->diffForHumans() }}
                          </small>
                        </td>

                        <td class="text-center" onclick="event.stopPropagation();">
                          <a href="{{ route('trainer.quizzes.show', $quiz->id) }}" class="btn btn-sm btn-info" title="View">
                            <i class="fas fa-eye"></i>
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center text-muted py-4">No quizzes found.</td>
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

    </div>
  </section>
</div>
@endsection
