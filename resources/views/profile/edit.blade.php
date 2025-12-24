@extends('admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      {{-- Flash Messages --}}
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

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="row justify-content-center">
        <div class="col-12 col-lg-12">

          {{-- Header Card --}}
          <div class="card shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
              <div class="d-flex align-items-center">
                <div class="mr-3">
                  <div class="rounded-circle bg-primary text-white"
                       style="width:52px;height:52px;display:flex;align-items:center;justify-content:center;font-weight:700;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                  </div>
                </div>

                <div>
                  <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                  <div class="text-muted">
                    <small>
                      {{ auth()->user()->email }}
                      <span class="mx-2">•</span>
                      Joined: {{ optional(auth()->user()->created_at)->format('d M Y') ?? '-' }}
                    </small>
                  </div>
                </div>
              </div>

              <div class="mt-3 mt-md-0 d-flex flex-wrap">
                <a href="{{ route('dashboard') }}" class="btn btn-light mr-2 mb-2">
                  <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
              </div>

            </div>
          </div>

          <div class="row">

            {{-- Left: Profile Info --}}
            <div class="col-12 col-lg-6">
              <div class="card shadow-sm mb-4">
                <div class="card-header">
                  <h5 class="mb-0"><i class="fas fa-user mr-1"></i> My Profile</h5>
                </div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <h6 class="text-muted mb-1">Full Name</h6>
                      <div class="font-weight-bold">{{ auth()->user()->name ?? '-' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-muted mb-1">Email</h6>
                      <div class="d-flex align-items-center">
                        <span class="mr-2">{{ auth()->user()->email ?? '-' }}</span>
                        @if(!empty(auth()->user()->email))
                          <a class="btn btn-sm btn-outline-secondary"
                             href="mailto:{{ auth()->user()->email }}" title="Send Email">
                            <i class="fas fa-envelope"></i>
                          </a>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-muted mb-1">Phone</h6>
                      <div class="d-flex align-items-center">
                        <span class="mr-2">{{ auth()->user()->phone ?? '-' }}</span>
                        @if(!empty(auth()->user()->phone))
                          <button class="btn btn-sm btn-outline-secondary" type="button"
                                  onclick="navigator.clipboard.writeText('{{ auth()->user()->phone }}')"
                                  title="Copy Phone">
                            <i class="far fa-copy"></i>
                          </button>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-muted mb-1">Registered On</h6>
                      <div>{{ optional(auth()->user()->created_at)->format('d M Y') ?? '-' }}</div>
                      <small class="text-muted">{{ optional(auth()->user()->created_at)->diffForHumans() ?? '' }}</small>
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                      <h6 class="text-muted mb-1">Role</h6>
                      <span class="badge badge-info text-uppercase py-2 px-3">
                        {{ auth()->user()->role ?? '-' }}
                      </span>
                    </div>

                    <div class="col-md-6">
                      <h6 class="text-muted mb-1">Status</h6>
                      @if(auth()->user()->status ?? 1)
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

            {{-- Right: Edit Form --}}
            <div class="col-12 col-lg-6">
              <div class="card shadow-sm mb-4">
                <div class="card-header">
                  <h5 class="mb-0"><i class="fas fa-edit mr-1"></i> Edit Profile</h5>
                </div>

                <div class="card-body">
                  <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                      <label>Full Name</label>
                      <input type="text" name="name" class="form-control"
                             value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email"
                             value="{{ auth()->user()->email }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>Mobile / Phone</label>
                      <input type="text" name="phone" class="form-control"
                             value="{{ old('phone', auth()->user()->phone) }}"
                             placeholder="03xx-xxxxxxx">
                    </div>

                    <button class="btn btn-primary">
                      <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                  </form>
                </div>
              </div>

              {{-- Optional: Link to change password page (already in your routes) --}}
              <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <div class="font-weight-bold">Security</div>
                    <small class="text-muted">Change your password</small>
                  </div>
                  <a href="{{ route('password.change') }}" class="btn btn-outline-secondary">
                    Change Password
                  </a>
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
