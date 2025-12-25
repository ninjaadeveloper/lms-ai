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

      <div class="row justify-content-center">
        <div class="col-12 col-lg-12">

          {{-- Header Card --}}
          <div class="card shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
              <div class="d-flex align-items-center">
                {{-- Avatar --}}
                <div class="mr-3">
                  <div class="rounded-circle bg-primary text-white"
                       style="width:52px;height:52px;display:flex;align-items:center;justify-content:center;font-weight:700;">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                  </div>
                </div>

                <div>
                  <h4 class="mb-1">{{ $user->name }}</h4>
                  <div class="text-muted">
                    <small>
                      {{ $user->email }}
                      <span class="mx-2">•</span>
                      Joined: {{ optional($user->created_at)->format('d M Y') ?? '-' }}
                    </small>
                  </div>
                </div>
              </div>

              <div class="mt-3 mt-md-0 d-flex flex-wrap">
                <a href="{{ route('users.index') }}" class="btn btn-light mr-2 mb-2">
                  <i class="fas fa-arrow-left mr-1"></i> Back
                </a>

                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary mr-2 mb-2">
                  <i class="fas fa-edit mr-1"></i> Edit
                </a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="mb-2">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt mr-1"></i> Delete
                  </button>
                </form>
              </div>

            </div>
          </div>

          <div class="row">

            {{-- Left: Profile Info --}}
            <div class="col-12 col-lg-7">
              <div class="card shadow-sm mb-4">
                <div class="card-header">
                  <h5 class="mb-0"><i class="fas fa-user mr-1"></i> Profile</h5>
                </div>

                <div class="card-body">

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <h6 class="text-muted mb-1">Full Name</h6>
                      <div class="font-weight-bold">{{ $user->name ?? '-' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-muted mb-1">Email</h6>
                      <div class="d-flex align-items-center">
                        <span class="mr-2">{{ $user->email ?? '-' }}</span>
                        @if(!empty($user->email))
                          <a class="btn btn-sm btn-outline-secondary"
                             href="mailto:{{ $user->email }}" title="Send Email">
                            <i class="fas fa-envelope"></i>
                          </a>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-muted mb-1">Phone</h6>
                      <div class="d-flex align-items-center">
                        <span class="mr-2">{{ $user->phone ?? '-' }}</span>
                        @if(!empty($user->phone))
                          <button class="btn btn-sm btn-outline-secondary" type="button"
                                  onclick="navigator.clipboard.writeText('{{ $user->phone }}')"
                                  title="Copy Phone">
                            <i class="far fa-copy"></i>
                          </button>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-muted mb-1">Registered On</h6>
                      <div>{{ optional($user->created_at)->format('d M Y') ?? '-' }}</div>
                      <small class="text-muted">{{ optional($user->created_at)->diffForHumans() ?? '' }}</small>
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                      <h6 class="text-muted mb-1">Role</h6>
                      <span class="badge badge-info text-uppercase py-2 px-3">
                        {{ $user->role ?? '-' }}
                      </span>
                    </div>

                    <div class="col-md-6">
                      <h6 class="text-muted mb-1">Status</h6>
                      @if($user->status)
                        <span class="badge badge-success py-2 px-3">
                          <i class="fas fa-check-circle mr-1"></i> Active
                        </span>
                      @else
                        <span class="badge badge-danger py-2 px-3">
                          <i class="fas fa-times-circle mr-1"></i> Inactive
                        </span>
                      @endif
                    </div>
                  </div>

                </div>
              </div>
            </div>

            {{-- Right: Quick Actions / Meta --}}
            <div class="col-12 col-lg-5">
              <div class="card shadow-sm mb-4">
                <div class="card-header">
                  <h5 class="mb-0"><i class="fas fa-bolt mr-1"></i> Quick Actions</h5>
                </div>
                <div class="card-body">

                  <div class="d-flex flex-column" style="gap:10px;">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary">
                      <i class="fas fa-edit mr-1"></i> Update Profile
                    </a>

                    @if(!empty($user->email))
                      <a href="mailto:{{ $user->email }}" class="btn btn-outline-secondary">
                        <i class="fas fa-envelope mr-1"></i> Email User
                      </a>
                    @endif

                    {{-- Optional: If you later add user courses / trainer courses --}}
                    {{-- <a href="#" class="btn btn-outline-info">
                      <i class="fas fa-book mr-1"></i> View Courses
                    </a> --}}
                  </div>

                  <hr>

                  <div class="text-muted">
                    <small>
                      Last Updated: {{ optional($user->updated_at)->format('d M Y') ?? '-' }}
                    </small>
                  </div>

                </div>
              </div>

              {{-- Optional: small “card” summary --}}
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <div class="text-muted"><small>User ID</small></div>
                      <div class="font-weight-bold">#{{ $user->id }}</div>
                    </div>
                    <div class="text-right">
                      <div class="text-muted"><small>Account</small></div>
                      @if($user->status)
                        <span class="badge badge-success">Enabled</span>
                      @else
                        <span class="badge badge-danger">Disabled</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>
@endsection
