@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      {{-- Flash Messages (optional) --}}
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
              <h4 class="mb-0">All Students</h4>

              {{-- Add button optional (normally students auto-create hote hain) --}}
              {{-- <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Student
              </a> --}}
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($students as $key => $student)

                      {{-- Row click -> student profile --}}
                      <tr style="cursor:pointer;"
                          onclick="window.location='{{ route('admin.users.show', $student->id) }}'">

                        <td>{{ $key + 1 }}</td>

                        <td>
                          <strong>{{ $student->name }}</strong><br>
                          <small class="text-muted">
                            Joined {{ optional($student->created_at)->diffForHumans() ?? '' }}
                          </small>
                        </td>

                        <td>{{ $student->email }}</td>

                        <td>
                          @if($student->status)
                            <span class="badge badge-success">Active</span>
                          @else
                            <span class="badge badge-danger">Not Active</span>
                          @endif
                        </td>

                        <td class="text-center" onclick="event.stopPropagation();">
                          {{-- View --}}
                          <a href="{{ route('admin.users.show', $student->id) }}" class="btn btn-sm btn-info" title="View">
                            <i class="fas fa-eye"></i>
                          </a>

                          {{-- Edit --}}
                          <a href="{{ route('admin.users.edit', $student->id) }}" class="btn btn-sm btn-primary" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>
                        </td>
                      </tr>

                    @empty
                      <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                          No students found.
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
