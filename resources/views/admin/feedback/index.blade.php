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

            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
              <h4 class="mb-2 mb-md-0"><i class="fas fa-inbox mr-1"></i> Feedback (Admin)</h4>

              <form class="form-inline" method="GET" action="{{ route('admin.feedback.admin') }}">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2 mb-2" placeholder="Search...">

                <select name="role" class="form-control mr-2 mb-2">
                  <option value="">All Roles</option>
                  <option value="student" {{ request('role')=='student'?'selected':'' }}>Student</option>
                  <option value="trainer" {{ request('role')=='trainer'?'selected':'' }}>Trainer</option>
                </select>

                <select name="status" class="form-control mr-2 mb-2">
                  <option value="">All Status</option>
                  <option value="new" {{ request('status')=='new'?'selected':'' }}>New</option>
                  <option value="read" {{ request('status')=='read'?'selected':'' }}>Read</option>
                  <option value="resolved" {{ request('status')=='resolved'?'selected':'' }}>Resolved</option>
                </select>

                <button class="btn btn-primary mb-2"><i class="fas fa-filter mr-1"></i> Filter</button>
              </form>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Role</th>
                      <th>Subject</th>
                      <th>Rating</th>
                      <th>Status</th>
                      <th>Created</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($feedbacks as $key => $f)
                      <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.feedback.show', $f->id) }}'">
                        <td>{{ ($feedbacks->currentPage()-1)*$feedbacks->perPage() + $key + 1 }}</td>
                        <td>
                          <strong>{{ $f->user->name ?? '-' }}</strong><br>
                          <small class="text-muted">{{ $f->user->email ?? '' }}</small>
                        </td>
                        <td><span class="badge badge-light text-capitalize">{{ $f->user_role ?? '-' }}</span></td>
                        <td>{{ $f->subject ?? '-' }}</td>
                        <td>{{ $f->rating ?? '-' }}</td>
                        <td>
                          @php $st = $f->status ?? 'new'; @endphp
                          <span class="badge badge-{{ $st=='new'?'danger':($st=='read'?'warning':'success') }}">
                            {{ strtoupper($st) }}
                          </span>
                        </td>
                        <td class="text-muted">{{ optional($f->created_at)->format('d M Y') }}</td>
                        <td class="text-center" onclick="event.stopPropagation();">
                          <a href="{{ route('admin.feedback.show', $f->id) }}" class="btn btn-sm btn-info" title="View">
                            <i class="fas fa-eye"></i>
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="8" class="text-center text-muted py-4">No feedback found.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            @if($feedbacks->hasPages())
              <div class="card-footer">
                {{ $feedbacks->links() }}
              </div>
            @endif

          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
