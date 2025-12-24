@extends('../admin.layout')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-body">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-12">

                    <div class="card">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <div class="card-header">
                                <h4>Change Password</h4>
                            </div>

                            <div class="card-body">

                                {{-- Current Password --}}
                                <div class="form-group">
                                    <label>Current Password <span class="text-danger">*</span></label>
                                    <input type="password"
                                           name="current_password"
                                           class="form-control @error('current_password') is-invalid @enderror"
                                           required>

                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- New Password --}}
                                <div class="form-group">
                                    <label>New Password <span class="text-danger">*</span></label>
                                    <input type="password"
                                           name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           required>

                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Confirm New Password --}}
                                <div class="form-group">
                                    <label>Confirm New Password <span class="text-danger">*</span></label>
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                           required>
                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">
                                    <i class="fas fa-key"></i> Update Password
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>

@endsection
