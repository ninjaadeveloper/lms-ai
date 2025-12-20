@extends('../admin.layout')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-light">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">User Details</h4>
                            <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">
                                Back to Users
                            </a>
                        </div>

                        <div class="card-body">

                            <!-- Name -->
                            <div class="mb-4">
                                <h6 class="text-muted">Full Name</h6>
                                <p class="h6">{{ $user->name }}</p>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <h6 class="text-muted">Email Address</h6>
                                <p>{{ $user->email }}</p>
                            </div>

                            <!-- Role & Status -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Role</h6>
                                    <span class="badge badge-info text-uppercase px-3 py-2">
                                        {{ $user->role }}
                                    </span>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-muted">Status</h6>
                                    @if($user->status)
                                        <span class="badge badge-success px-3 py-2">Active</span>
                                    @else
                                        <span class="badge badge-danger px-3 py-2">Inactive</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="mb-4">
                                <h6 class="text-muted">Phone</h6>
                                <p>{{ $user->phone ?? '-' }}</p>
                            </div>

                            <!-- Created At -->
                            <div class="mb-4">
                                <h6 class="text-muted">Registered On</h6>
                                <p>{{ $user->created_at->format('d M Y') }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
