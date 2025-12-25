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
              <div>
                <h4 class="mb-0">Enrolled Students</h4>
                <small class="text-muted">
                  Course: <strong>{{ $course->title ?? '—' }}</strong>
                </small>
              </div>

              <div class="d-flex flex-wrap">
                <a href="{{ route('trainer.enrollments.index') }}" class="btn btn-light btn-sm mr-2 mb-2">
                  <i class="fas fa-arrow-left mr-1"></i> Back
                </a>

                {{-- Optional: open course show --}}
                <a href="{{ route('trainer.courses.show', $course->id) }}" class="btn btn-info btn-sm mb-2">
                  <i class="fas fa-book mr-1"></i> Course Detail
                </a>
              </div>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th style="width:70px;">#</th>
                      <th>Student</th>
                      <th>Email</th>
                      <th>Enrolled At</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($enrollments as $key => $row)
                      <tr>
                        <td>
                          {{ ($enrollments->currentPage() - 1) * $enrollments->perPage() + $key + 1 }}
                        </td>

                        <td>
                          <strong>{{ $row->student_name ?? '-' }}</strong>
                        </td>

                        <td>
                          @if(!empty($row->student_email))
                            <span class="text-muted">{{ $row->student_email }}</span>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>

                        <td>
                          @php
                            $dt = $row->enrolled_at ?? $row->created_at ?? null;
                          @endphp
                          @if($dt)
                            <span class="badge badge-light">
                              {{ \Carbon\Carbon::parse($dt)->format('d M Y, h:i A') }}
                            </span>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                          No students enrolled in this course yet.
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
