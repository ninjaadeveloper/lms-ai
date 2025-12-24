@extends('../admin.layout')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                            @csrf
                            @method('PUT') <!-- PUT required for update -->

                            <div class="card-header">
                                <h4>Edit User</h4>
                            </div>
                            <div class="card-body">

                                <!-- Name -->
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('name', $user->name) }}" required>
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        value="{{ old('email', $user->email) }}" required>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label>Password (Leave blank if not changing)</label>
                                    <input type="password" name="password" 
                                        class="form-control @error('password') is-invalid @enderror">
                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Role -->
                                <div class="form-group">
                                    <label>Role <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="admin" {{ old('role', $user->role)=='admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="trainer" {{ old('role', $user->role)=='trainer' ? 'selected' : '' }}>Trainer</option>
                                        <option value="student" {{ old('role', $user->role)=='student' ? 'selected' : '' }}>Student</option>
                                    </select>
                                    @if($errors->has('role'))
                                        <div class="invalid-feedback">{{ $errors->first('role') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Phone -->
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" 
                                        class="form-control @error('phone') is-invalid @enderror" 
                                        value="{{ old('phone', $user->phone) }}">
                                    @if($errors->has('phone'))
                                        <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label>Status</label><br>
                                    <input type="checkbox" name="status" value="1" {{ old('status', $user->status) ? 'checked' : '' }}> Active
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
