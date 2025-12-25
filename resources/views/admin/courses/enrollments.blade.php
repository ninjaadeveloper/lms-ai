@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      {{-- Flash Messages --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
          {{ session('error') }}
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      @endif

      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">

            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-center">
              <div>
                <h4 class="mb-0">Enrolled Students</h4>
                <small class="text-muted">
                  Course: <strong>{{ $course->title }}</strong>
                </small>
              </div>

              <a href="{{ route('admin.courses.show', $course->id) }}"
                 class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Course
              </a>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Student Name</th>
                      <th>Email</th>
                      <th>Enrolled At</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($enrollments as $key => $row)
                      <tr>
                        <td>{{ $key + 1 }}</td>

                        <td>
                          <strong>{{ $row->student_name }}</strong>
                        </td>

                        <td>
                          <span class="text-muted">{{ $row->student_email }}</span>
                        </td>

                        <td>
                          {{ \Carbon\Carbon::parse($row->enrolled_at)->format('d M Y, h:i A') }}
                        </td>

                        <td class="text-center">
                          {{-- Remove enrollment --}}
                          <form action="{{ route('admin.courses.removeStudent', [$course->id, $row->student_id]) }}"
                                method="POST"
                                style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Remove this student from course?')"
                                    title="Remove">
                              <i class="fas fa-user-times"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                          No students enrolled in this course.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            {{-- Pagination --}}
            @if(method_exists($enrollments, 'links'))
              <div class="card-footer text-right">
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
