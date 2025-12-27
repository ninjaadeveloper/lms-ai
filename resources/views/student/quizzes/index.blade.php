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

      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0">My Quizzes</h4>

              <form method="GET" class="d-flex" style="gap:8px;">
                <select name="course_id" class="form-control form-control-sm" onchange="this.form.submit()">
                  <option value="">All Courses</option>
                  @foreach($courses as $c)
                    <option value="{{ $c->id }}" @selected(request('course_id')==$c->id)>{{ $c->title }}</option>
                  @endforeach
                </select>
              </form>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Course</th>
                      <th>Topic</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($quizzes as $key => $quiz)
                      @php
                        $att = $attempts[$quiz->id] ?? null;
                        $done = $att && $att->submitted_at;
                      @endphp
                      <tr style="cursor:pointer;" onclick="window.location='{{ route('student.quizzes.show', $quiz->id) }}'">
                        <td>{{ $quizzes->firstItem() + $key }}</td>
                        <td><strong>{{ $quiz->course?->title }}</strong></td>
                        <td>{{ $quiz->topic }}</td>
                        <td>{{ $quiz->total_questions }}</td>
                        <td>
                          @if($done)
                            <span class="badge badge-success">Submitted</span>
                          @else
                            <span class="badge badge-warning">Pending</span>
                          @endif
                        </td>
                        <td class="text-center" onclick="event.stopPropagation();">
                          <a class="btn btn-sm btn-info" href="{{ route('student.quizzes.show', $quiz->id) }}">
                            <i class="fas fa-play"></i> Start
                          </a>
                          @if($done)
                            <a class="btn btn-sm btn-primary" href="{{ route('student.quizzes.result', $quiz->id) }}">
                              <i class="fas fa-chart-bar"></i> Result
                            </a>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center text-muted py-4">No quizzes found.</td>
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
