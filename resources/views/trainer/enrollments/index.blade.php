@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      {{-- Flash Message --}}
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
              <h4 class="mb-0">All Enrollments (My Courses)</h4>

              <a href="{{ route('trainer.courses.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> My Courses
              </a>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th style="width:60px;">#</th>
                      <th>Student</th>
                      <th>Email</th>
                      <th>Course</th>
                      <th>Enrolled At</th>
                      <th class="text-center" style="width:170px;">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($enrollments as $key => $row)
                      <tr style="cursor:pointer;"
                          onclick="window.location='{{ route('trainer.courses.show', $row->course_id) }}'">

                        <td>
                          {{ ($enrollments->currentPage() - 1) * $enrollments->perPage() + $key + 1 }}
                        </td>

                        <td>
                          <strong>{{ $row->student_name ?? '-' }}</strong>
                        </td>

                        <td>
                          <span class="text-muted">{{ $row->student_email ?? '-' }}</span>
                        </td>

                        <td>
                          <strong>{{ $row->course_title ?? '-' }}</strong><br>
                          <small class="text-muted">Course ID: {{ $row->course_id ?? '-' }}</small>
                        </td>

                        <td>
                          @if(!empty($row->enrolled_at))
                            <span class="badge badge-light">
                              {{ \Carbon\Carbon::parse($row->enrolled_at)->format('d M Y, h:i A') }}
                            </span>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>

                        {{-- ACTION ICONS --}}
                        <td class="text-center" onclick="event.stopPropagation();">
                          {{-- course show --}}
                          <a href="{{ route('trainer.courses.show', $row->course_id) }}"
                             class="btn btn-sm btn-info" title="View Course">
                            <i class="fas fa-eye"></i>
                          </a>

                          {{-- per-course enrollments --}}
                          <a href="{{ route('trainer.courses.enrollments', $row->course_id) }}"
                             class="btn btn-sm btn-secondary" title="This Course Enrollments">
                            <i class="fas fa-users"></i>
                          </a>
                        </td>

                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                          No enrollments found for your courses.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>

                </table>
              </div>
            </div>

            @if(method_exists($enrollments, 'links'))
              <div class="card-footer">
                {{ $enrollments->links() }}
              </div>
            @endif

          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
