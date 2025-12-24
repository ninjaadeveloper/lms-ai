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
              <h4 class="mb-0">All Users</h4>
              <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add User
              </a>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($users as $key => $user)
                      {{-- ROW CLICK -> DETAILS --}}
                      <tr style="cursor:pointer;"
                          onclick="window.location='{{ route('admin.users.show', $user->id) }}'">

                        <td>{{ $key + 1 }}</td>

                        <td>
                          <strong>{{ $user->name }}</strong><br>
                          <small class="text-muted">Created {{ $user->created_at->diffForHumans() }}</small>
                        </td>

                        <td>{{ $user->email }}</td>

                        <td>
                          <span class="badge badge-light">
                            {{ ucfirst(strtolower($user->role)) }}
                          </span>
                        </td>

                        <td>
                          @if($user->status)
                            <span class="badge badge-success">Active</span>
                          @else
                            <span class="badge badge-danger">Not Active</span>
                          @endif
                        </td>

                        <td class="text-center" onclick="event.stopPropagation();">
                          {{-- ICON -> DETAILS --}}
                          <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info" title="View">
                            <i class="fas fa-eye"></i>
                          </a>

                          <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>

                          <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" title="Delete">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>

                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            <div class="card-footer text-right">
              {{-- If later you use paginate(): --}}
              {{-- {{ $users->links() }} --}}
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
