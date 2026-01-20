
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4>Create Account</h4>
                        <p class="text-muted mb-0">Join the learning platform</p>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            {{-- Role hidden --}}
                            <input type="hidden" name="role" value="student">

                            <button type="submit" class="btn btn-primary btn-block">
                                Create Account
                            </button>
                        </form>
                    </div>

                    <div class="card-footer text-center">
                        Already have an account?
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>