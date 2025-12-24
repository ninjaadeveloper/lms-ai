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
              <h4 class="mb-0">All Courses</h4>
              <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Course
              </a>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Trainer</th>
                      <th>Video</th>
                      <th>PDF</th>
                      <th>Duration</th>
                      <th>Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($courses as $key => $course)

                      {{-- ROW CLICK --}}
                      <tr style="cursor:pointer;"
                          onclick="window.location='{{ route('courses.show', $course->id) }}'">

                        <td>{{ $key + 1 }}</td>

                        <td>
                          <strong>{{ $course->title }}</strong><br>
                          <small class="text-muted">
                            {{ Str::limit($course->description, 50) }}
                          </small>
                        </td>

                        <td>
                          @php
                            $tName = $course->trainer_id
                              ? ($trainersMap[$course->trainer_id] ?? null)
                              : null;
                          @endphp

                          @if($tName)
                            <span class="badge badge-light">{{ $tName }}</span>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>

                        <td>
                          @if($course->video_url)
                            <i class="fas fa-video text-info" title="Video available"></i>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>

                        <td>
                          @if($course->pdf_file)
                            <i class="far fa-file-pdf text-success" title="PDF available"></i>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>

                        <td>{{ $course->duration_hours ? $course->duration_hours.' hrs' : '-' }}</td>

                        <td>
                          @if($course->status)
                            <span class="badge badge-success">Active</span>
                          @else
                            <span class="badge badge-danger">Inactive</span>
                          @endif
                        </td>

                        {{-- ACTION ICONS --}}
                        <td class="text-center" onclick="event.stopPropagation();">
                          <a href="{{ route('courses.show', $course->id) }}"
                             class="btn btn-sm btn-info" title="View">
                            <i class="fas fa-eye"></i>
                          </a>

                          <a href="{{ route('admin.courses.edit', $course->id) }}"
                             class="btn btn-sm btn-primary" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>

                          <form action="{{ route('admin.courses.destroy', $course->id) }}"
                                method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')"
                                    title="Delete">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>

                      </tr>

                    @empty
                      <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                          No courses found.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>

                </table>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
