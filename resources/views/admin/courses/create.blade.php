@extends('../admin.layout')

@section('content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form method="POST" action="{{ route('courses.store') }}">
                            @csrf
                            <div class="card-header">
                                <h4>Add Course</h4>
                            </div>
                            <div class="card-body">

                                <!-- Title -->
                                <div class="form-group">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" 
                                        class="form-control @error('title') is-invalid @enderror" 
                                        value="{{ old('title') }}" required>
                                    @if($errors->has('title'))
                                        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" 
                                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @if($errors->has('description'))
                                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>
                                <!-- Duration -->
                                <div class="form-group">
                                    <label>Duration (hours)</label>
                                    <input type="number" name="duration_hours" 
                                        class="form-control @error('duration_hours') is-invalid @enderror" 
                                        value="{{ old('duration_hours') }}" min="1">
                                    @if($errors->has('duration_hours'))
                                        <div class="invalid-feedback">{{ $errors->first('duration_hours') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label>Status</label><br>
                                    <input type="checkbox" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}> Active
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
